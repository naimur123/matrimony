<?php

use Illuminate\Support\Facades\Route;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 *  All Inatall and Update Function
 *  @Author Sm Shahjalal Shaju.
 *	Email: shajushahjalal@gmail
 *  
 */

Route::get('/install','Install\InstallController@ShowInstallPage')->name('install');
Route::post('/install','Install\InstallController@Install');

Route::middleware(['Install'])->group(function(){
	Route::get('install/update','Install\InstallController@ShowUpdatePage')->name('install.update');  
	Route::post('install/update','Install\InstallController@UpdateInstall');  
});
