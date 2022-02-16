<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Components\Profile;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Proposal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ProposalController extends Controller
{
    use Profile;
    /**
     * Accept Proposal
     */
    public function acceptProposal(Request $request){
        try{
            // if( !$this->checkActivityPermission('accept_proposal', Auth::user()) ){
            //     return $this->output();
            // }
            $proposal = Proposal::find($request->proposal_id);
            if( is_null($proposal)){
                $this->message = "Sorry! This Proposal is not exists at this time";
                return $this->output();
            }
            if($proposal->status == "accept"){
                $this->message = "You already accept this Proposal";
                return $this->output();
            }
            $proposal->status = "accept";
            $proposal->save();
            $this->success('Proposal Accepted');
            $this->table = false;
            $this->button = true;
            $this->url = URL::previous();
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Reject Proposal
     */
    public function rejectProposal(Request $request){
        try{
            $proposal = Proposal::find($request->proposal_id);
            if( is_null($proposal)){
                $this->message = "Sorry! This Proposal is not exists at this time";
                return $this->output();
            }
            if($proposal->status == "reject"){
                $this->message = "You already reject this Proposal";
                return $this->output();
            }
            $proposal->status = "reject";
            $proposal->save();
            $this->updateUserActivity('decline', Auth::user()->id);
            $this->success('Proposal Rejected');
            $this->table = false;
            $this->url = URL::previous();
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Cancel Proposal
     */
    public function cancelProposal(Request $request){
        try{
            DB::beginTransaction();
            $proposal = Proposal::where('proposal_sent_to', $request->profile_id)
                ->where('proposal_sent_from', Auth::user()->id)->first();
            if( empty($proposal) ){
                $this->message = 'You haven\'t sent any Proposal Yet';
            }else{
                Notification::where('proposal_id', $proposal->id)->delete();
                $proposal->delete();
                $this->success();
                $this->message = "Proposal Canceled Successfully";                
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }
}
