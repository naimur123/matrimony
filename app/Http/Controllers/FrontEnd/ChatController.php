<?php

namespace App\Http\Controllers\FrontEnd;

use App\Chat;
use App\ChatTracking;
use App\Http\Components\Profile;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    use Profile;
    /**
     * Get Chat History
     */
    public function getChat(Request $request){
        if($request->ajax()){
            if( !$this->checkActivityPermission('message', Auth::user(), $request->user_id) ){
                return $this->apiOutput();
            }
            DB::beginTransaction();
            $parms['user'] = Auth::user();
            $to_id = $request->user_id;            

            $chats = Chat::where('to_id', $to_id)->where('from_id', Auth::user()->id)
                ->orWhere(function($qry)use($to_id){
                    $qry->where('to_id', Auth::user()->id)->where('from_id', $to_id);
                })->limit('50')->orderBy('id', 'DESC')->get()->reverse();

            Chat::where('from_id', $to_id)
                ->where('to_id', Auth::user()->id)
                ->update(['load' => true, 'seen_at' => Carbon::now() ]);
            // dd($chats);
            $parms['chats'] = $chats;
            DB::commit();
            if( count($chats) > 0 ){
                $this->data = view('frontEnd.chatting.load-chat-body', $parms)->render();
            }else{
                $this->data = "<div style=\"padding:30px 10px;text-align:center;\"><b>You are connect with this person. Now you can send a message<b></div>";
            }
            
            $this->apiSuccess();
            return $this->apiOutput();
        }
    }

    

    /**
     * Get or Load Unload chat
     */
    public function getUnloadChat(Request $request){
        if($request->ajax()){
            try{
                if( $this->isBlockProfile(Auth::user()->id, $request->user_id) || $this->isBlockProfile($request->user_id, Auth::user()->id) ){
                    $this->message = "<b><p style=\"color:red;text-align:center;\">You Can't reply this conversation</p><b>";
                    return $this->apiOutput();
                }

                if( !$this->checkActivityPermission('message', Auth::user(), $request->user_id) ){
                    $this->message = $this->packageUpgradeMessage();
                    return $this->apiOutput();
                }
                DB::beginTransaction();
                $to_id = $request->user_id;       
                $parms['user'] = Auth::user();
                $parms['chats'] = Chat::where('from_id', $to_id)->where('to_id', Auth::user()->id)
                    ->where(function($qry){
                        $qry->where('load', '=', Null)->orWhere('load', false);
                    })->orderBy('id', 'DESC')->get()->reverse();
    
                Chat::where('from_id', $to_id)
                    ->where('to_id', Auth::user()->id)
                    ->update(['load' => true, 'seen_at' => Carbon::now() ]);
                DB::commit();
                $this->data = view('frontEnd.chatting.load-chat-body', $parms)->render();
                $this->apiSuccess();
            }catch(Exception $e){
                return Null;
            }  
            return $this->apiOutput();          
        }
        return Null;
    }

    /**
     * Send Message to User
     */
    public function sendMessage(Request $request){
        if($request->ajax()){
            try{ 
                if( $this->isBlockProfile(Auth::user()->id, $request->user_id) || $this->isBlockProfile($request->user_id, Auth::user()->id) ){
                    $this->message = "<b><p style=\"color:red;text-align:center;\">You Can't reply this conversation</p><b>";
                    return $this->apiOutput();
                }

                if( !$this->checkActivityPermission('message', Auth::user(), $request->user_id) ){
                    return $this->apiOutput();
                }                
                DB::beginTransaction();
                $this->setChatUser(Auth::user(), $request->user_id);           
                $data = new Chat();
                $data->from_id = Auth::user()->id;
                $data->to_id = $request->user_id;
                $data->message = $request->message;
                $data->save();
                $this->data = $data->message;
                $this->apiSuccess();                
                DB::commit();
            }catch(Exception $e){
                $this->message = $this->getError($e);
            }
            return $this->apiOutput();
        }
    }

    /**
     * Put Package ID with User and Chatting Person data
     * For thack or check the chat limit person
     */
    protected function setChatUser($user, $to_user_id){
        $data = ChatTracking::where('user_id', $user->id)
            ->where('subscribe_package_id', $user->subscribePackage->id)
            ->where('to_user_id', $to_user_id)->first();
        if( empty($data) ){
            $data = new ChatTracking();
            $data->user_id = $user->id;
            $data->user_id = $user->id;
            $data->subscribe_package_id = $user->subscribePackage->id;
            $data->to_user_id = $to_user_id;
            $data->save();
        }
    }
}
