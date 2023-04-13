<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Au

class GeneralController extends Controller
{
    public function getnotif(){
        $notif = Notification::where('id_user', Auth::user()->id)->get();
        return json_encode($notif->toArray());
    }
}
