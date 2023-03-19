<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AppointmentController extends Controller
{
    public function index()
    {
        $data = DB::table('appointment')->get();
        return view('admin.appointment',['data'=>$data]);
    }
    public function change(Request $request)
    {
        DB::table('appointment')->where('id',$request->id)->update([
            'status' => $request->status,
        ]);

        return response()->json(['message'=>'success'], 200);
    }
    public function detail($id)
    {
        return view('admin.detail-appointment',['data'=>DB::table('appointment')->where('id',$id)->first()]);
    }
    public function destroy($id)
    {
        DB::table('appointment')->where('id', $id)->delete();
        return redirect()->route('admin.appointment.index')->with(['message'=>'appointment berhasil di delete','status'=>'success']);
    }
}
