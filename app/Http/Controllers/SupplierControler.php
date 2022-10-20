<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use Illuminate\Http\Request;

class SupplierControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account= supplier::where('com_code',auth()->user()->com_code)->get();
        return view('supplier.index',compact('account'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.create');

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


        ],[
            'name.required' =>'ادخل اسم الحساب',
            'name.string' =>'ادخل حروف فقط',
            'balance_status.required' =>'ادخل حاله الحساب',
            'balance.required' =>'ادخل رصيد الحساب',
        ]);
        if ($request->balance_status!=2 && ($request->balance<=0 || $request->balance==null))
        {
            return redirect()->back()->with('error','لابد من ادخال قيمة الرصيد ');
        }
        if($request->balance_status==2)
        {
            $request->balance=0;
        }


        supplier::create([
            'name'=>$request->name,
            'balance_status'=>"2",
            'address'=>$request->address,
            'phone'=>$request->phone,
            'com_code'=>auth()->user()->com_code,
            'balance'=>"0",
            'start_balance'=>$request->balance,
            'start_balance_status'=>$request->balance_status,

        ]);
        return redirect()->back()->with('success','تم اضافة المورد بنجاح ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(supplier $supplier)
    {

        return view('supplier.edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, supplier $supplier)
    {
        $request->validate([
            'name' =>'required|string|max:255',
            'address' =>'required|string|max:255',
            'phone' =>'required|string|max:255',
            'balance_status' =>'required|integer',


        ],[
            'name.required' =>'ادخل اسم الحساب',
            'name.string' =>'ادخل حروف فقط',
            'balance_status.required' =>'ادخل حاله الحساب',
            'balance.required' =>'ادخل رصيد الحساب',
        ]);
        if ($request->balance_status!=2 && ($request->balance<=0 || $request->balance==null))
        {
            return redirect()->back()->with('error','لابد من ادخال قيمة الرصيد ');
        }
        if($request->balance_status==2)
        {
            $request->balance=0;
        }
        
        $supplier->update([
            'name'=>$request->name,
            'balance_status'=>"2",
            'address'=>$request->address,
            'phone'=>$request->phone,
            'com_code'=>auth()->user()->com_code,
            'balance'=>"0",
            'start_balance'=>$request->balance,
            'start_balance_status'=>$request->balance_status,

        ]);
        return redirect()->back()->with('success','تم تعديل المورد بنجاح ');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
