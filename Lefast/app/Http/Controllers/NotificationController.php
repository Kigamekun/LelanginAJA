<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.notification', [
            'data' => Notification::all()
        ]);
    }

    public function store(Request $request)
    {
        Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'for' => $request->for,
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
        Notification::where('id',$id)->update([
            'title' => $request->title,
            'message' => $request->message,
            'for' => $request->for,
        ]);

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
        Notification::where('id', $id)->delete();
        return redirect()->route('admin.notifications.index')->with(['message'=>'Notification berhasil di delete','status'=>'success']);
    }
}
