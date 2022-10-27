<?php

namespace App\Http\Controllers;

use App\Models\capital;
use App\Models\exchangeRevenue;
use App\Models\safe;
use Illuminate\Http\Request;

class CapitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account= capital::where('com_code',auth()->user()->com_code)->get();
        return view('capital.index',compact('account'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('capital.create');

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
        ]);
        if ($request->balance_status!=2 && ($request->balance<=0 || $request->balance==null))
        {
            return redirect()->back()->with('error','لابد من ادخال قيمة الرصيد ');
        }
        if($request->balance_status==2)
        {
            $request->balance=0;
        }
        elseif ($request->balance_status==3)
        {
            $request->balance*=-1;
        }


        capital::create([
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'com_code'=>auth()->user()->com_code,
            'balance'=>$request->balance,
            'balance_status'=>$request->balance_status,

        ]);
        return redirect()->back()->with('success','تم اضافة راس المال  بنجاح ');
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
    public function edit(capital $capital)
    {

        return view('capital.edit',compact('capital'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, capital $capital)
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

        $capital->update([
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'com_code'=>auth()->user()->com_code,
            'balance'=>$request->balance,
            'balance_status'=>$request->balance_status,

        ]);
        return redirect()->back()->with('success','تم تعديل المورد بنجاح ');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\capital  $capital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $capital=capital::find($request->id);
        if($capital->balance_status!=2)
        {
            return $this->error('لابد من ان يكون الحساب متزن ');
        }
        //$capital->exchangeRevenue()->delete();
        $capital->delete();
        return $this->success('تمت الارشفة ');
    }

    public function pay(Request $request)
    {
        $capital=capital::find($request->id);
        $status=2;
        if($capital->balance +$request->payed >0)
        {
            $status=1;
        }
        elseif ($capital->balance +$request->payed <0)
        {
            $status=3;
        }
        $capital->update(['balance' => $capital->balance +$request->payed ,'balance_status' => $status]);
        exchangeRevenue::create(['fk' => $capital->id, 'amount' => -1*($request->payed), 'type' => 6, 'com_code' => $capital->com_code]);

        $safe=safe::where('com_code',$this->getAuthData('com_code'))->first();
        $safe->update(['amount'=>$safe->amount - $request->payed]);
        return $this->success('تم الدفع بنجاح');
    }

    public function collect(Request $request)
    {
        $capital=capital::find($request->id);
        $status=2;
        if($capital->balance -$request->payed >0)
        {
            $status=1;
        }
        elseif ($capital->balance -$request->payed <0)
        {
            $status=3;
        }
        $capital->update(['balance' => $capital->balance -$request->payed,'balance_status' => $status]);
        exchangeRevenue::create(['fk' => $capital->id, 'amount' => ($request->payed), 'type' => 6, 'com_code' => $capital->com_code]);

        $safe=safe::where('com_code',$this->getAuthData('com_code'))->first();

        $safe->update(['amount'=>$safe->amount + $request->payed]);
        return $this->success('تم التحصيل بنجاح');
    }
}
