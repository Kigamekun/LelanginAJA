<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateSnapTokenService extends Midtrans
{
    protected $auction;
    public function __construct($auction)
    {
        parent::__construct();
        $this->auction = $auction;
    }
    public function getSnapToken()
    {
        $user = User::where('id',$this->auction->user_id)->first();
            $item[] = [
                'price' => $this->auction->auction_price,
                'name' => substr($this->auction->name, 0, 7).'...',
                'quantity' => 1,
            ];
        $params = [
            'transaction_details' => [
                'order_id' => Carbon::now()->timestamp,
                'gross_amount' => 1,
            ],
            'item_details' => $item,
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ]
        ];
        $snapToken = Snap::getSnapToken($params);
        return $snapToken;
    }
}