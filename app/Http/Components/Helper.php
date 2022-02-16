<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Components;

use Exception;
use Illuminate\Support\Str;

/**
 *
 * @author Shaju
 */
trait Helper {
    /**
     * Generate or get Slug
     */
    protected function getSlug($title = Null, $model = Null, $edit = false){
        if( !is_null($title) ){ 
            $slug = ""; 
            if( !preg_match('/[^\x20-\x7e]/', $title)){
                $slug = Str::slug($title); 
            }             
            $slug = empty($slug) ? $this->generateSlug($title) : $slug;
            if( !$model == Null ){
                $exixts = $model->where('slug', $slug)->get();
                if( count($exixts) > 0 && !$edit ){
                    $slug = $slug.'-'.time();
                }                
            }
            return $slug;
        }else{
            return time();
        }        
    }
    /**
     * Generate Slug NUmber For All Language
     */
    protected function generateSlug($title, $seperator = '-'){
        $title = str_replace(['- ',' -',' '], $seperator, $title);
        $title = str_replace('@', 'AT', $title);
        $title = strip_tags($title);
        return trim($title);
    }

    /*
     * -------------------------------------------------
     * Make Number Format 
     * _________________________________________________
     */
    public function makeNumber($data) {
        return str_replace( [',',"'",'-'], '', $data );
    }

    /**
     * Get Data From IP Address
     */
    protected function getDataFromIP($ip){
        try{
            $url = "http://ip-api.com/json/".$ip;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $data = json_decode(curl_exec($ch));
            return $data;
        }catch(Exception $e){            
            return Null;
        }
        
    }


}
