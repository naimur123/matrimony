<?php

namespace App\Http\Controllers;


use App\Http\Components\FileUpload;
use App\Http\Components\Helper;
use App\Http\Components\Message;
use App\Http\Components\Permission as AdminPermission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use Helper, Message, FileUpload, AdminPermission;
    protected $index = 0;
}
