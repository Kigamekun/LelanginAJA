<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\{Auction,Product};
class GreatherThanMaxBid implements InvokableRule
{
    private int $product_id;
    public function __construct($product_id)
    {
        $this->product_id = $product_id;

    }

    /**
         * Run the validation rule.
         *
         * @param  string  $attribute
         * @param  mixed  $value
         * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
         * @return void
         */
    public function __invoke($attribute, $value, $fail)
    {
        $maxBid = Auction::where('product_id',$this->product_id)->orderBy('auction_price','DESC')->first();
        if (!is_null($maxBid)) {
            if ($value <= $maxBid->auction_price) {
                $fail('The bid must be greater than Rp. ' . number_format($maxBid->auction_price, 0, ',', '.'));
            }
        } else {
            if ($value <= Product::where('id',$this->product_id)->first()->start_from) {
                $fail('The bid must be greater than Rp. ' . number_format(Product::where('id',$this->product_id)->first()->start_from, 0, ',', '.'));
            }
        }



    }
}
