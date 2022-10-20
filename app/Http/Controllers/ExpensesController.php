<?php

namespace App\Http\Controllers;

use App\Models\expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account= expenses::where('com_code',auth()->user()->com_code)->get();
        return view('expenses.index',compact('account'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');

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
            


        ],[
            'name.required' =>'ادخل اسم الحساب',
            'name.string' =>'ادخل حروف فقط',
            
        ]);


        expenses::create([
            'name'=>$request->name,
            'created_by'=>auth()->user()->name,
    
            'com_code'=>auth()->user()->com_code,
            
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
    public function edit(expenses $expenses)
    {

        return view('expenses.edit',compact('expenses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, expenses $expenses)
    {
        $request->validate([
            'name' =>'required|string|max:255',
        ],[
            'name.required' =>'ادخل اسم الحساب',
            'name.string' =>'ادخل حروف فقط',
            
        ]);
        
        $expenses->update([
            'name'=>$request->name,
            'updated_by'=>auth()->user()->name,
            'com_code'=>auth()->user()->com_code,
        ]);
        return redirect()->back()->with('success','تم تعديل المصروف بنجاح ');


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
