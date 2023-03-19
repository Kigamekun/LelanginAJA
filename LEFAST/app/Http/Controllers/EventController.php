<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.event', [
            'data' => DB::table('event')->get()
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
        // $this->validate($request, [
        //     'gambar' => 'required',
        // ]);


        DB::table('event')->insert([
            'title' => $request->title,
            'location' => $request->location,
            'price' => str_replace(".", "",$request->price),
        ]);



        return redirect()->back()->with(['message'=>'Event berhasil ditambahkan','status'=>'success']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('event')->where('id', $id)->update([
            'title' => $request->title,
            'location' => $request->location,
            'price' =>str_replace(".", "",$request->price),
        ]);

        return redirect()->back()->with(['message'=>'Event berhasil di update','status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('event')->where('id', $id)->delete();
        return redirect()->route('admin.event.index')->with(['message'=>'Event berhasil di delete','status'=>'success']);
    }
}
