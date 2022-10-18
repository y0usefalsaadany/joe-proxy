<?php

namespace Yousefpackage\JoeProxy\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yousefpackage\Visits\Models\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Mail;
use Yousefpackage\JoeProxy\Mail\AlertMail;

class HelperController extends Controller
{
    static function manyRequests($ip,$page,$city = null){
        $data = [
            "subject"=>'hello Admin how are you',
            "ip" =>$ip,
            'page'=>$page,
            'city'=>$city
        ];
        Mail::to(env('MAIL_TO'))->send(new AlertMail($data));
    }
}
