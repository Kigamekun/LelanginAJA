<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
    
        $x = Auction::orderBy('auction_price', 'DESC')->get()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('Y-m');
        });


        $solve = [];
        $y = [];
        $temp = [];

        foreach ($x as $key => $value) {
            $ym = explode('-', $key);
            $year = $ym[0];
            $month = $ym[1];
            if (in_array($year,$y)) {
                $data = $temp;
            } else {
                $temp = [];
                $data = [0,0,0,0,0,0,0,0,0,0,0,0];
            }
            $data[(int)$month - 1] = $value[0]->auction_price;
            $solve[$year]['name'] = $year;
            // $solve[$year]['month'] = $month;
            $solve[$year]['data'] = $data;
            $y[] = $year;
            $temp = $data;
        }

        $ans  = [];

        foreach ($solve as $key => $value) {
            $ans[] = (object)$value;
        }



        return view('admin.index', ['income'=>$ans]);
    }

    public function chat(Request $request)
    {
        return view('admin.chat');
    }



public function chatDetail(Request $request,$id)
    {
        return view('admin.detail-chat',['id'=>$id]);
    }

}
