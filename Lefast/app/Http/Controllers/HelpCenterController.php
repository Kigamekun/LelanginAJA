<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HelpCenter;

class HelpCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.help-center', [
            'data' => HelpCenter::all()
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




        return redirect()->back()->with(['message'=>'Banner berhasil ditambahkan','status'=>'success']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $thumbname = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '/help-center' . '/', $thumbname);
            Product->where('id', $id)->update([
                'gambar' => $thumbname,
            ]);
        }



        return redirect()->back()->with(['message'=>'Banner berhasil di update','status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product->where('id', $id)->delete();
        return redirect()->route('admin.help-center.index')->with(['message'=>'Banner berhasil di delete','status'=>'success']);
    }
}
