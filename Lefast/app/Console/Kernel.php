<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\{Auction,User};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\{BlacklistMail};
use Illuminate\Support\Facades\Mail;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            foreach (DB::table('auctions')
            ->select('id','product_id','user_id','payment_status','last_payment', DB::raw('MAX(auction_price) as highest_price'))
            ->groupBy('product_id')->where('last_payment','<=',date('Y-m-d H:i:s'))
            ->get() as $key => $value) {
                if ($value->payment_status == 1) {
                    $ac = Auction::find($value->id);
                    Auction::where('product_id',$value->product_id)->orderBy('auction_price')->limit(1)->update([
                        'last_payment' => date('Y-m-d H:i:s', strtotime($ac->last_payment. ' + '.env('PAYMENT_LIMIT')))
                    ]);
                    User::where('id',$value->user_id)->update([
                        'blacklist' => TRUE
                    ]);
                    Mail::to($ac->user->email)->send(new BlacklistMail());
                    $ac->delete();
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
