<?php

namespace App\Http\Controllers;

use App\Models\account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account=account::where('com_code',auth()->user()->com_code)->get();
       return  view('account.index',compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account.create');
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
            'balance_status' =>'required|integer',
            'account_type' =>'required|integer',
            'balance'=>'required|numeric'
        ],[
            'name.required' =>'ادخل اسم الحساب',
            'name.string' =>'ادخل حروف فقط',
            'balance_status.required' =>'ادخل حاله الحساب',
            'account_type.required' =>'ادخل نوع الحساب',
            'balance.required' =>'ادخل رصيد الحساب',
        ]);
       account::create([
           'name'=>$request->name,
           'balance_status'=>$request->balance_status,
           'account_type'=>$request->account_type,
           'com_code'=>auth()->user()->com_code,
           'balance'=>$request->balance
       ]);
       return redirect()->back()->with('success','تم اضافة الحساب بنجاح ');

    }

    public function customersView()
    {
        $account=account::where('com_code',auth()->user()->com_code)->where('account_type','3')->get();//3=>customers
        return  view('customers.index',compact('account'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $account)
    {
        account::find($account->id)->delete();
        return redirect()->back()->with('success',"تم حذف الحساب بنجاح");
    }
}
