<?php

namespace App\Console\Commands;

use App\Http\Components\Message;
use App\User;
use App\Visitor;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class AutoOffline extends Command
{
    use Message;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:offline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make user as offline which are not active last 10 mins';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $time = Carbon::now()->subMinutes(5);
            $yesterday = Carbon::now()->subDays(1);
            $active_users_arr = Visitor::where('user_id', '!=', Null )
                ->where('updated_at', '<', $time)
                // ->where('updated_at','>=', $yesterday)
                ->select('user_id')->pluck('user_id');
            if( count($active_users_arr) > 0 ){
                User::where('is_online', 1)->whereIn('id', $active_users_arr)
                ->update(['is_online' => 0]);
            } 
            $this->info('Make Offline Successfully'); 
        }catch(Exception $e){
            $this->error($this->getError($e));
        }
    }
}
