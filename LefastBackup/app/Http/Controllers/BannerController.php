<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banner', [
            'data' => DB::table('banner')->get()
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
            'thumb' => 'required',
        ]);


        if ($request->hasFile('thumb')) {
            $file = $request->file('thumb');
            $thumbname = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '/thumbBanner' . '/', $thumbname);
            DB::table('banner')->insert([
                'title' => $request->title,
                'description' => $request->description,
                'thumb' => $thumbname,
            ]);
        }



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
        if ($request->hasFile('thumb')) {
            $file = $request->file('thumb');
            $thumbname = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '/thumbBanner' . '/', $thumbname);
            DB::table('banner')->where('id', $id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'thumb' => $thumbname,
            ]);
        }
        else {
            DB::table('banner')->where('id', $id)->update([
                'title' => $request->title,
                'description' => $request->description,

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
        DB::table('banner')->where('id', $id)->delete();
        return redirect()->route('admin.banner.index')->with(['message'=>'Banner berhasil di delete','status'=>'success']);
    }
}
