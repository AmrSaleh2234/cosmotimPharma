<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function adminDashboard()
    {
        $currentDate = \Carbon\Carbon::now();
        $startLastWeek = \Carbon\Carbon::now()->subDays($currentDate->dayOfWeek + 1)->subWeek();//start of last week
        $startCurrentWeek = \Carbon\Carbon::now()->startOfWeek(\Illuminate\Support\Carbon::SATURDAY)->format('Y-m-d');//start of current week
        $endLastWeek = \Carbon\Carbon::now()->endOfWeek(\Illuminate\Support\Carbon::FRIDAY)->subWeek();// end of the
        $endCurrentWeek = \Carbon\Carbon::now()->endOfWeek(\Illuminate\Support\Carbon::FRIDAY)->format('Y-m-d');// end of the current week
        $invoicesCurrentWeek = \App\Models\invoice_customer::where('created_at', '>=',$startCurrentWeek)->where('created_at','<=',$endCurrentWeek)->where('com_code',$this->getAuthData('com_code'))->get();
        $invoicesLastWeek = \App\Models\invoice_customer::whereBetween('created_at', [$startLastWeek, $endLastWeek])->where('com_code',$this->getAuthData('com_code'))->get();
        $startLastMonth = \Carbon\Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d H:i');//start of last week
        $startCurrentMonth = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d H:i');//start of current week
        $endLastMonth = \Carbon\Carbon::now()->endOfMonth()->subMonth()->format('Y-m-d H:i');// end of the
        $endCurrentMonth = \Carbon\Carbon::now()->endOfMonth();// end of the current week
        $invoicesCurrentMonth = \App\Models\invoice_customer::whereBetween('created_at', [$startCurrentMonth, $endCurrentMonth])->where('com_code',$this->getAuthData('com_code'))->get();
        $invoicesLastMonth = \App\Models\invoice_customer::whereBetween('created_at', [$startLastMonth, $endLastMonth])->where('com_code',$this->getAuthData('com_code'))->get();
        $total_after = \App\Models\invoice_customer::selectRaw('year(created_at) year, month(created_at) month, sum(total_after) total, com_code ')
            ->groupBy('year', 'month','com_code')->whereYear('created_at', date('Y'))->where('com_code',$this->getAuthData('com_code'))
            ->orderBy('year', 'desc')
            ->get();
        $profit = \App\Models\invoice_customer::selectRaw('year(created_at) year, month(created_at) month, sum(profit) total, com_code ')
            ->groupBy('year', 'month','com_code')->whereYear('created_at', date('Y'))->where('com_code',$this->getAuthData('com_code'))
            ->orderBy('year', 'desc')
            ->get();
        $topCustomer = \App\Models\invoice_customer::selectRaw('customer_id id ,  sum(total_after) total , sum(payed) total_payed, com_code ')
            ->groupBy('customer_id','com_code')->whereYear('created_at', date('Y'))->where('com_code',$this->getAuthData('com_code'))
            ->orderBy('total', 'desc')
            ->get();
        $customer = [];
        foreach ($topCustomer as $item) {
            $temp = customer::find($item->id);
            $temp->total = $item->total;
            $temp->total_payed = $item->total_payed;
            array_push($customer, $temp);
        }
//        return view('admin.admin', compact('invoicesCurrentWeek',
//            'invoicesLastWeek'
//            ,'invoicesCurrentMonth'
//            , 'invoicesLastMonth'
//            , 'total_after'
//            , 'profit'
//            ,'customer'
//
//        ));
        return $invoicesCurrentWeek;
    }

    public function usersList()
    {
        $users=User::all();
        return view('user.list',compact('users'));
    }


}
