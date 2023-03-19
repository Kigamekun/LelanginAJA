<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product,Auction,Bookmark};
use Illuminate\Support\Facades\Auth;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Support\Facades\DB;
use App\Mail\{WinnerAuctionMail};
use Illuminate\Support\Facades\Mail;
use App\Rules\GreatherThanMaxBid;
use Carbon\Carbon;
use App;
class CoreController extends Controller
{
    public function detail($id)
    {
        $data = Product::where('id', $id)->first();
        return view('detail', ['data'=>$data]);
    }
    
     public function history()
    {
        $data = Auction::where('user_id', Auth::id())->get();
        return view('history', ['data'=>$data]);
    }
    
    public function refresh(){
        
        foreach (Auction::where('snap_token', '!=', null)->where('payment_status',1)->get() as $key => $value) {
            $curl = curl_init();
            curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/1676947867/status",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic U0ItTWlkLXNlcnZlci1FUXRnQ1E5Mm0yaXVtTHFCek9NNXU1YVQ6"
            ],
            ]);
            $response = json_decode(curl_exec($curl));
        
            if($response->status_code == 200){
            if ($response->fraud_status == 'accept') {
                Auction::where('id', $value->id)->update([
                    'transaction_time'=>$response->transaction_time,
                    'payment_type'=>$response->payment_type ,
                    'payment_status_message'=>$response->status_message,
                    'transaction_id'=>$response->transaction_id,
                    
                    'jumlah_pembayaran'=>$response->gross_amount,
                    'payment_status'=>2,
                ]);
            } else if($response->fraud_status == 'challenge'){
                Auction::where('id', $value->id)->update([
                    'transaction_time'=>$response->transaction_time,
                    'payment_type'=>$response->payment_type ,
                    'payment_status_message'=>$response->status_message,
                    'transaction_id'=>$response->transaction_id,
                
                    'jumlah_pembayaran'=>$response->gross_amount,
                    'payment_status'=>1,
                ]);
            } else {
                Auction::where('id', $value->id)->update([
                    'transaction_time'=>$response->transaction_time,
                    'payment_type'=>$response->payment_type,
                    'payment_status_message'=>$response->status_message,
                    'transaction_id'=>$response->transaction_id,
                   
                    'jumlah_pembayaran'=>$response->gross_amount,
                    'payment_status'=>4,
                ]);
            }
            }

        }
        return redirect()->route('history');
    }
    
    
    public function addBookmark(Request $request)
    {
        DB::table('bookmarks')->insert(['user_id'=>Auth::id(),'product_id'=>$request->item_id]);
        return response()->json(['id'=>$request->item_id], 200);
    }

    public function deleteBookmark(Request $request)
    {
        DB::table('bookmarks')->where(['user_id'=>Auth::id(),'product_id'=>$request->item_id])->delete();
        return response()->json(['id'=>$request->item_id], 200);
    }


    public function auctionList()
    {
        if (Auth::check()) {
            if (empty($_GET)) {
                $data = Product::leftJoin('bookmarks', function ($join) {
                    $join->on('products.id', '=', 'bookmarks.product_id');
                    $join->on('bookmarks.user_id', '=', DB::raw(Auth::user()->id));
                })->select('products.*', 'bookmarks.id as bookmarked')
                ->get();
            } else {

                if (isset($_GET['query'])) {
                    $data = Product::where('name', 'LIKE', '%'.$_GET['query'].'%')->leftJoin('bookmarks', function ($join) {
                        $join->on('products.id', '=', 'bookmarks.product_id');
                        $join->on('bookmarks.user_id', '=', DB::raw(Auth::user()->id));
                    })->select('products.*', 'bookmarks.id as bookmarked')->get();
                }

                if (isset($_GET['status']) && $_GET['status'] != 'Status') {
                    if($_GET['status'] == 0){
                        $data = Product::where('end_auction','<=', Carbon::now());
                        
                    } else {
                        $data = Product::where('end_auction','>', Carbon::now());
                    }
                    
                    
                    
                       
                    if(isset($_GET['categories'])){
                        $data->whereIn('category_id',$_GET['categories']);
                    }
                    
                    if (isset($_GET['lower']) && isset($_GET['upper'])) {
                        
                    $data = $data->where('start_from', '>=', str_replace(".", "", $_GET['lower']))->where('start_from', '<=', str_replace(".", "", $_GET['upper']))->leftJoin('bookmarks', function ($join) {
                        $join->on('products.id', '=', 'bookmarks.product_id');
                        $join->on('bookmarks.user_id', '=', DB::raw(Auth::user()->id));
                    })->select('products.*', 'bookmarks.id as bookmarked')->get();
                }
                
                } else if (isset($_GET['status']) && $_GET['status'] == 'Status'){
                    
                    $data = Product::where('products.id','!=',null);
                    
                    if(isset($_GET['categories'])){
                        $data->whereIn('category_id',$_GET['categories']);
                    }
                      
                   $data = $data->where('start_from', '>=', str_replace(".", "", $_GET['lower']))->where('start_from', '<=', str_replace(".", "", $_GET['upper']))->leftJoin('bookmarks', function ($join) {
                        $join->on('products.id', '=', 'bookmarks.product_id');
                        $join->on('bookmarks.user_id', '=', DB::raw(Auth::user()->id));
                    })->select('products.*', 'bookmarks.id as bookmarked')->get();
               
                } 
                
            }
        } else {
            if (empty($_GET)) {
                $data = Product::all();
            } else {
                

                if (isset($_GET['status']) && $_GET['status'] != 'Status') {
                     if($_GET['status'] == 0){
                        $data = Product::where('end_auction','<=', Carbon::now());
                        
                    } else {
                        $data = Product::where('end_auction','>', Carbon::now());
                    }
                } else {
                    $data = Product::where('products.id','!=',null);
                } 
                if (isset($_GET['query'])) {
                    $data = Product::where('name', 'LIKE', '%'.$_GET['query'].'%')->get();
                }
              
                    if(isset($_GET['categories'])){
                        $data->whereIn('category_id',$_GET['categories']);
                    }
                    
                if (isset($_GET['lower']) && isset($_GET['upper'])) {
                    $data = $data->where('start_from', '>=', $_GET['lower'])->get();
                }
            }
        }
          
        $min = Product::orderBy('start_from', 'ASC')->first()->start_from;
        $max = Product::orderBy('start_from', 'DESC')->first()->start_from;

        return view('auction-list', ['data'=>$data,'min'=>$min,'max'=>$max]);
    }
    public function setBid(Request $request, $product_id)
    {
        $request->validate([

            'auction_price' => ['required', new GreatherThanMaxBid($product_id)],
        ]);



        $auct = Auction::updateOrCreate(['product_id' => $product_id,
        'user_id' => Auth::id(),], [
            'auction_price' => str_replace(".", "",$request->auction_price),
            'product_id' => $product_id,
            'user_id' => Auth::id(),
            'payment_status'=>1,
            'last_payment' => date('Y-m-d H:i:s', strtotime(Product::where('id', $product_id)->first()->end_auction. ' + '.env('PAYMENT_LIMIT')))
        ]);

        Auction::where('product_id', $product_id)->where('id', '!=', $auct->id)->update([
            'last_payment' => null
        ]);
        return redirect()->back();
    }

    public function filter(Request $request)
    {
        if (isset($_GET['status'])) {
            $data = Product::where('name', 'LIKE', '%'.$_GET['query'].'%');
        }
        if (isset($_GET['category'])) {
            $data = Product::where('name', 'LIKE', '%'.$_GET['query'].'%');
        }
        if (isset($_GET['range'])) {
            $data = Product::where('name', 'LIKE', '%'.$_GET['query'].'%');
        }

        $min = Product::orderBy('start_from', 'ASC')->first()->price;
        $max = Product::orderBy('start_from', 'DESC')->first()->price;
        return view('auction-list', ['data'=>$data,'min'=>$min,'max'=>$max]);
    }

    public function notifications(Request $request)
    {
        $data = DB::table('notifications')->where('for', Auth::id())->get();
        return view('notification', ['data'=>$data]);
    }


    public function getSnapToken($id)
    {
        $auction = Auction::find($id);
        $snapToken = $auction->snap_token;
        if (empty($snapToken)) {
            $midtrans = new CreateSnapTokenService($auction);
            $snapToken = $midtrans->getSnapToken();
            $auction->snap_token = $snapToken;
            $auction->save();
        }
        return response()->json(['snapToken'=>$snapToken,'auction'=>$id], 200);
    }

    public function helpCenter()
    {
        return view('help-center');
    }

    public function bookmarks()
    {
        $data = Bookmark::where('user_id', Auth::id())->get();
        return view('bookmarks', ['data'=>$data]);
    }

    public function cst(Request $request)
    {
        try {
            Auction::where('id', $request->auction)->update([
                'transaction_time'=>$request->result['transaction_time'],
                'payment_type'=>$request->result['payment_type'] . "-" .$request->result['bank'],
                'payment_status_message'=>$request->result['status_message'],
                'transaction_id'=>$request->result['transaction_id'],
                
                'jumlah_pembayaran'=>$request->result['gross_amount'],
            ]);
        } catch (\Throwable $th) {
            Auction::where('id', $request->auction)->update([
                'transaction_time'=>$request->result['transaction_time'],
                'payment_type'=>$request->result['payment_type'],
                'payment_status_message'=>$request->result['status_message'],
                'transaction_id'=>$request->result['transaction_id'],
              
                'jumlah_pembayaran'=>$request->result['gross_amount'],
            ]);
        }
        if ($request->status == "success") {
            Auction::where('id', $request->auction)->update([
                'payment_status'=>2,
            ]);
        } elseif ($request->status == 'pending') {
            Auction::where('id', $request->auction)->update([
                'paymment_status'=>1,
            ]);
        } elseif ($request->status == 'error') {
            Auction::where('id', $request->auction)->update([
                'paymment_status'=>4,
            ]);
        }


        Product::where('id', Auction::where('id', $request->auction)->first()->product_id)->update([
            'status'=>'0',
        ]);


        Mail::to(Auction::where('id', $request->auction)->first()->user->email)->send(new WinnerAuctionMail($request->auction));

        return response()->json(['message'=>'Update Transaction','status'=>'success'], 200);
    }

    public function chat(Request $request)
    {
        return view('chat');
    }

    public function cancelBid(Request $request, $id)
    {
        Auction::find($id)->delete();
        return redirect('history');
    }
      public function appointment()
    {
        return view('appointment');
    }
    public function setAppointment(Request $request)
    {
        $file = $request->file('thumb');
        $thumbname = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path() . '/thumbAppointment' . '/', $thumbname);
        DB::table('appointment')->insert([
            'user_id'=>Auth::id(),
            'description'=> $request->description,
             'phone'=> $request->phone,
              'schedule'=> $request->schedule,
            'longitude'=>$request->longitude,
            'latitude'=>$request->latitude,
            'thumb'=>$thumbname,
            'status'=>'pending',

        ]);
        return redirect()->back()->with(['status'=>'success','message'=>'Appointment has been successfully']);
    }
    
        public function change(Request $request)

    {

        App::setLocale($request->lang);

        session()->put('locale', $request->lang);

  

        return redirect()->back();

    }
}
