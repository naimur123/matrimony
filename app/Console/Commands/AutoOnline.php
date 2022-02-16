<?php

namespace App\Console\Commands;

use App\Http\Components\Message;
use App\User;
use App\Visitor;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class AutoOnline extends Command
{
    use Message;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:online';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make user as online when active';

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
            $active_users_arr = Visitor::where('user_id', '!=', Null )->where('updated_at', '>=', $time)->groupBy('user_id')->select('user_id')->pluck('user_id');
            if( count($active_users_arr) > 0 ){
                User::whereIn('id', $active_users_arr)->where('is_online', 0)->update([
                    'is_online' => 1, 'login_at' => Carbon::now()
                ]);
            }
            $this->info('Make Online Successfully');
        }catch(Exception $e){
            $this->error($this->getError($e));
        }
        
    }
}
