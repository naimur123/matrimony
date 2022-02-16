<?php

namespace App\Http\Components;

trait Message{
    
    protected $status = false;
    protected $message = '';   
    protected $reset = false; 
    protected $modal = false;
    protected $table = false;    
    protected $button = false;
    protected $url = false;
    protected $api_token = "";
    protected $html_page = false;
    protected $data = [];
    

    /**
     * Return Default Output Message
     * This Method for web JSON Response
     */
    protected function output($message = Null){
        return [ 
            'status' => $this->status, 'message' => is_null($message) ? $this->message : $message, 'reset' => $this->reset,
            'table' => $this->table, 'modal' => $this->modal, 'button' => $this->button,'url' => $this->url, 'html_page' => $this->html_page,
        ];
    }

    /**
     *  Success  Function Set the Value as Success
     * This Method for Web Success Message
     */
    protected function success( $smg = null, $reset = true, $modal = true, $table = true, $button = false){
        $this->status = true;
        $this->message = $smg == null ? !empty($this->message) ? $this->message : 'Information Save Successfully' : $smg ;
        $this->reset = $reset;
        $this->modal = $modal;
        $this->table = $table;
        $this->button = $button;
    }

    /**
     * Success  Function For API
     * Set api response status as Success
     * This Method is responsible all API Response
     */
    protected function apiSuccess($message = Null, $data = Null){
        $this->status = true;
        $this->message = !empty($message) ? $message : 'Successfully';
        if( !is_null($data) ){
            $this->data = $data;
        }
    }

    /**
     * Return Default API Output Message
     * This Method for API Response
     */
    protected function apiOutput($message = Null){
        $output = ['status'    => $this->status,       'message'   => is_null($message) ? $this->message : $message];
        if( !is_null($this->api_token) ){
            $output['api_token'] = $this->api_token;
        } 
        $output['data'] = $this->data;
        return $output;
    }

    /**
     * Get Error Message
     * If Application Environtment is local then
     * Return Error Message With filename and Line Number
     * else return a Simple Error Message
     */
    protected function getError($e = null){
        if( strtolower(env('APP_ENV')) == 'local' && !empty($e) ){
            $error =  $e->getMessage() . ' On File ' . $e->getFile() . ' on line ' . $e->getLine();
            return str_replace('\\','/', $error);
        }
        return 'Something went wrong!';
    }

    

    /**
     * Get Validation Error
     */
    public function getValidationError($validator){
        if( strtolower(env('APP_ENV')) == 'local' ){
            return $validator->errors()->first();
        }
        return 'Data Validation Error';
    }
}
