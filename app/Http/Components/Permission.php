<?php

namespace App\Http\Components;


trait Permission{
    /**
     * Check Supper Admin Permission
     * is exists or Not
     */
    protected function checkPermission($model, $key = "user_type", $check = "super_admin"){
        if( $model->$key == $check ){
            return true;
        }
        return false;
    }

    // protected function permissionFailed($error_code = 401, $redirectTo = Null){
    //     if( !empty($redirectTo) ){
    //         return redirect($redirectTo);
    //     }
    //     return abort($error_code);
    // }
}