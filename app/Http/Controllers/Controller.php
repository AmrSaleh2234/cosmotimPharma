<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getAuthData($data)
    {
        return auth()->user()->$data;
    }
    public function success($message)
    {
        return redirect()->back()->with('success',$message);
    }
    public function error($message)
    {
        return redirect()->back()->with('error',$message);
    }
    
}
