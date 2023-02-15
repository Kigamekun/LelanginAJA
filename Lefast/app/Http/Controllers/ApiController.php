<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product,Auction,Banner,User};
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
// use App\Models\{};
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use App\Rules\GreatherThanMaxBid;

class ApiController extends Controller
{
    public function product(Request $request)
    {
        if (isset($_GET['id'])) {
            $data = Product::where('id', $_GET['id'])->first();
            $data['thumb'] = env('API_URL').'/thumb/'.$data->thumb;
            if (date('Y-m-d H:i:s') >= $data->end_auction) {
                $data['is_bid'] = -1;
            } elseif (Auction::where(['user_id'=> $request->user()->id,'product_id'=>$_GET['id']])->count() > 0) {
                $data['is_bid'] = 1;
            } else {
                $data['is_bid'] = 0;
            }

            $data['current_bid'] = Auction::where('product_id', $data->id)->count();
            $data['highest_bid'] = number_format(!is_null($ac = Auction::where('product_id', $data->id)->orderBy('auction_price','DESC')->first()) ? $ac->auction_price: 0,0,',','.');
            $data['auction_closed'] = date_format(date_create($data->end_auction), 'F m, H:i (e)') ;
            $data['start_from'] = number_format($data->start_from, 0, ',', '.');
            return response()->json(['data'=>$data], 200);
        } else {
            $data = Product::all();
            $solve = [];
            foreach ($data as $key => $value) {
                $solve[$key]= $value;
                $solve[$key]['thumb'] = env('API_URL').'/thumb/'.$value->thumb;
            }
            return response()->json(['data'=>$solve], 200);
        }
    }

    public function bidder(Request $request)
    {


        $data = Auction::where('product_id', $_GET['id'])->orderBy('auction_price','DESC')->get();

        foreach ($data as $key => $value) {
            $data[$key]['name'] = $value->user->name;
            $data[$key]['auction_price'] = 'Rp.'.number_format($value->auction_price, 0, ',', '.');

            if ($key == 0) {
                $data[$key]['is_win'] = TRUE;
            } else {
                $data[$key]['is_win'] = FALSE;

            }

            if ($request->user()->id == $value->user->id) {
                $data[$key]['is_you'] = TRUE;
            } else {
                $data[$key]['is_you'] = FALSE;
            }
        }
        return response()->json(['data'=>$data], 200);
    }

    public function banner()
    {
        $data = Banner::all();
        $solve = [];
        foreach ($data as $key => $value) {
            $solve[$key]= $value;
            $solve[$key]['thumb'] = env('API_URL').'/thumbBanner/'.$value->thumb;
        }
        return response()->json(['data'=>$solve], 200);
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'state'=>'required',
            'zipcode'=>'required',
            'country'=>'required',
        ]);

        User::where('id', $request->user()->id)->update([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'state'=>$request->state,
            'zipcode'=>$request->zipcode,
            'country'=>$request->country,

        ]);
        return response()->json(['message'=>'sudah ter edit','data'=>User::where('id', $request->user()->id)->first()], 200);
    }


    public function history(Request $request)
    {
        $data = Auction::where('user_id', $request->user()->id)->get();
        foreach ($data as $key => $value) {
            if (Carbon::now() >= $value->product->end_auction) {
                if (
                    $value->id ==
                        Auction::where('product_id', $value->product->id)->orderBy('auction_price', 'DESC')->first()->id) {
                    if (!is_null($value->snap_token) && $value->payment_status == 2) {
                        $data[$key]['status'] = 3;
                    } else {
                        $data[$key]['status'] = 2;
                    }
                } else {
                    $data[$key]['status'] = 1;
                }
            } else {
                $data[$key]['status'] = 0;
            }

            if (is_null($data[$key]['courier'])) {
                $data[$key]['courier'] = 'On Progress';
            }


            if (is_null($data[$key]['airplane'])) {
                $data[$key]['airplane'] = 'On Progress';
            }

            if (is_null($data[$key]['no_resi'])) {
                $data[$key]['no_resi'] = 'On Progress';
            }

            if (is_null($data[$key]['file_resi'])) {
                $data[$key]['file_resi'] = 'On Progress';
            }

            $data[$key]['product'] = $value->product;
            $data[$key]['product']['thumb'] = env('API_URL').'/thumb/'.$data[$key]['product']['thumb'];
        }
        return response()->json(['data'=>$data], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }


    public function pay(Request $request, $id)
    {
        $auction = Auction::find($id);
        $snapToken = $auction->snap_token;
        if (empty($snapToken)) {
            $midtrans = new CreateSnapTokenService($auction);
            $snapToken = $midtrans->getSnapToken();
            $auction->snap_token = $snapToken;
            $auction->save();
        }
        return view('api.pay', ['snapToken'=>$snapToken,'auction'=>$id]);
    }

    public function payFinish()
    {
        return view('api.pay-finish');
    }

    public function bid(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'auction_price' => ['required', new GreatherThanMaxBid($id)],
        ]);

        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first('auction_price')], 400);
        }


        Auction::updateOrCreate(['product_id' => $id,
        'user_id' => $request->user()->id,], [
            'auction_price' => $request->auction_price,
            'product_id' => $id,
            'user_id' => $request->user()->id,
        ]);


        return response()->json(['message'=>'success'], 200);
    }

    public function cancelBid(Request $request)
    {
        Auction::find($_GET['id'])->delete();
        return response()->json(['message'=>'Auction Terdelete','status'=>'success'], 200);
    }
}

