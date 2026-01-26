<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function microsoft()
    {
        $user = auth()->user();
        dd($user);
        return view('settings.microsoft', [
            'isConnected' => !empty($user->ms_access_token),
            'msEmail'     => $user->ms_email
        ]);
    }
}