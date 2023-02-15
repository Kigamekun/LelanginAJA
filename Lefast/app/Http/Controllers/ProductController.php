<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product', [
            'data' => Product::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('thumb');
        $thumbname = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path() . '/thumb' . '/', $thumbname);
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_from' =>$request->start_from,
            'end_auction' => $request->end_auction,
            'condition' => $request->condition,
            'saleroom_notice' => $request->saleroom,
            'created_by' => Auth::id(),
            'catalogue_note' => $request->catalogue,
            'thumb' => $thumbname
        ]);




        return redirect()->back()->with(['message'=>'Product berhasil ditambahkan','status'=>'success']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->hasFile('thumb')) {
            $file = $request->file('thumb');
            $thumbname = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '/thumb' . '/', $thumbname);
            Product::where('id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'start_from' =>$request->start_from,
                'end_auction' => $request->end_auction,
                'condition' => $request->condition,
                'saleroom_notice' => $request->saleroom,

                'catalogue_note' => $request->catalogue,
                'thumb' => $thumbname
            ]);
        } else {
            Product::where('id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'start_from' =>$request->start_from,
                'end_auction' => $request->end_auction,
                'condition' => $request->condition,
                'saleroom_notice' => $request->saleroom,

                'catalogue_note' => $request->catalogue,

            ]);
        }



        return redirect()->back()->with(['message'=>'Product berhasil di update','status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route('admin.product.index')->with(['message'=>'Product berhasil di delete','status'=>'success']);
    }

    public function stop($id)
    {
        $date = date('Y-m-d h:i:s', strtotime("-1 days"));

        Product::where('id', $id)->update(['end_auction'=>$date]);
        return redirect()->route('admin.product.index')->with(['message'=>'Product berhasil di stop','status'=>'success']);
    }
}
