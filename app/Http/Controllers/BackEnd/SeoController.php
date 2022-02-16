<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Seo;

class SeoController extends Controller
{
    // Show All Seo Content
    public function show() {
        $data = Seo::first();
        return view('backEnd.seo.manageSeo',['data'=>$data])->withNav('seo');
    }
    
    // Store or save Seo Information
    public function store(Request $request) {
        try{
            DB::beginTransaction();
                if($request->id == 0){
                $seo = new Seo();
            }else{
                $seo = Seo::find($request->id);
            }        
            $seo->seo = $this->RemoveContent($request->seo);
            $seo->save();
            DB::commit();
            $this->status = true;
            $this->message = 'Save Successfully';
            return response()->json( $this->output());           
        } catch (Exception  $e) {
            DB::rollback();
            $this->message = $this->getError($e);
            return response()->json($this->output());
        }
    }
    
    protected function RemoveContent($text) {
        return str_replace('<br>', '', str_replace('</p>','', str_replace('<p>','', $text)));
    }
}
