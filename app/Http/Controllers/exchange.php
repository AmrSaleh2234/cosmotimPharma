<?php

namespace App\Http\Controllers;

use App\Models\exchangeRevenue;
use Illuminate\Http\Request;

class exchange extends Controller
{
    public function index()
    {
        $exchange=exchangeRevenue::where('com_code',$this->getAuthData('com_code'))->get();
        return view('reports.exchange',compact('exchange'));
    }
}
