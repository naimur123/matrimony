<?php

namespace App\Http\Components;

trait Curl{

    /*
     * Curl Execute
     */
    protected function curl($url, $method = "GET", $post_data = "", $ssl = true) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url );
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1 );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if($ssl){
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC
        }
        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if( $code == 200 ){
            $this->status = true;
            return $response;
        }else{
            $this->message = "FAILED TO CONNECT WITH Server";
            return false;
        }
    }
           
}