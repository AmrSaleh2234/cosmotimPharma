<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account=customer::where('com_code',auth()->user()->com_code)->get();

       return  view('customer.index',compact('account'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|string|max:255',
            'address' =>'required|string|max:255',
            'phone' =>'required|string|max:255',
            'balance_status' =>'required|integer',
            'discount'=>'required|numeric|min:0|max:100'


        ],[
            'name.required' =>'ادخل اسم الحساب',
            'name.string' =>'ادخل حروف فقط',
            'balance_status.required' =>'ادخل حاله الحساب',
            'account_type.required' =>'ادخل نوع الحساب',
            'balance.required' =>'ادخل رصيد الحساب',
        ]);
        if ($request->balance_status!=2 && ($request->balance<=0 || $request->balance==null))
        {
            return redirect()->back()->with('error','لابد من ادخال قيمة الرصيد ');
        }
        if($request->balance == null)
        {
            $request->balance=0;
        }


       customer::create([
           'name'=>$request->name,
           'balance_status'=>"2",
           'address'=>$request->address,
           'phone'=>$request->phone,
           'discount'=>$request->discount,
           'com_code'=>auth()->user()->com_code,
           'balance'=>"0",
           'start_balance'=>$request->balance,
           'start_balance_status'=>$request->balance_status,

       ]);
       return redirect()->back()->with('success','تم اضافة العميل بنجاح ');


    }

    public function customersView()
    {
        $account=customer::where('com_code',auth()->user()->com_code)->where('account_type','3')->get();//3=>customers
        return  view('customers.index',compact('account'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $account
     * @return \Illuminate\Http\Response
     */
    public function show(customer $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $account)
    {
        customer::find($account->id)->delete();
        return redirect()->back()->with('success',"تم حذف الحساب بنجاح");
    }
}
