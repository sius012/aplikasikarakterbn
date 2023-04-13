<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function getnotifuser(){
        $notif = Notification::where('id_user', Auth::user()->id)->get();
    }
}
