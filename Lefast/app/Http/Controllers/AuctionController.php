<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;

class AuctionController extends Controller
{
    /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
    public function index()
    {
        return view('admin.auction', [
            'data' => Auction::all()
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
        $this->validate($request, [
            'title' => 'required',
            'location' =>'required',
            'price' => 'required',
        ]);


        Auction::create([
            'title' => $request->title,
            'location' => $request->location,
            'price' => $request->price,
        ]);



        return redirect()->back()->with(['message'=>'Auction berhasil ditambahkan','status'=>'success']);
    }

    public function ship(Request $request, $id)
    {
        $file = $request->file('file_resi');
        $thumbname = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path() . '/fileResi' . '/', $thumbname);
        Auction::where('id', $id)->update([
            'courier' => $request->courier,
            'airplane' => $request->airplane,
            'no_resi' => $request->no_resi,
            'file_resi' => $thumbname,
        ]);


        return redirect()->back()->with(['message'=>'Auction berhasil ditambahkan','status'=>'success']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auction  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Auction::where('id', $id)->update([
            'title' => $request->title,
            'location' => $request->location,
            'price' => $request->price,
        ]);

        return redirect()->back()->with(['message'=>'Auction berhasil di update','status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auction::where('id', $id)->delete();
        return redirect()->route('admin.auction.index')->with(['message'=>'Auction berhasil di delete','status'=>'success']);
    }
}
