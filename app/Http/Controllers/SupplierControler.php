<?php

namespace App\Http\Controllers;

use App\Models\exchangeRevenue;
use App\Models\safe;
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
        $account = supplier::where('com_code', auth()->user()->com_code)->get();
        return view('supplier.index', compact('account'));

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'balance_status' => 'required|integer',


        ], [
            'name.required' => 'ادخل اسم الحساب',
            'name.string' => 'ادخل حروف فقط',
            'balance_status.required' => 'ادخل حاله الحساب',
            'balance.required' => 'ادخل رصيد الحساب',
        ]);
        if ($request->balance_status != 2 && ($request->balance < 0 || $request->balance == null)) {
            return redirect()->back()->with('error', 'لابد من ادخال قيمة الرصيد ');
        }
        if ($request->balance_status == 2) {
            $request->balance = 0;
        }


        supplier::create([
            'name' => $request->name,
            'balance_status' => $request->balance_status,
            'address' => $request->address,
            'phone' => $request->phone,
            'com_code' => auth()->user()->com_code,
            'balance' => $request->balance,
            'start_balance' => $request->balance,
            'start_balance_status' => $request->balance_status,

        ]);
        return redirect()->back()->with('success', 'تم اضافة المورد بنجاح ');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(supplier $supplier)
    {

        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'balance_status' => 'required|integer',


        ], [
            'name.required' => 'ادخل اسم الحساب',
            'name.string' => 'ادخل حروف فقط',
            'balance_status.required' => 'ادخل حاله الحساب',
            'balance.required' => 'ادخل رصيد الحساب',
        ]);
        if ($request->balance_status != 2 && ($request->balance < 0 || $request->balance == null)) {
            return redirect()->back()->with('error', 'لابد من ادخال قيمة الرصيد ');
        }
        if ($request->balance_status == 2) {
            $request->balance = 0;
        }
        $total = 0;

        $updated_balance = $supplier->balance;
        foreach ($supplier->invoice_supplier as $invoice) {
            $total += $invoice->total - $invoice->payed;
        }
        $start_balance = $supplier->balance - $total;// ely matbky mn start balance
        $difr = $request->balance - $supplier->start_balance;
        $updated_balance += $difr;
        if ($start_balance != $supplier->start_balance) {
            return $this->error('لقد دفعت لهذا المورع من قبل لا يمكن التعديل ');
        }

        $status = 2;
        if ($updated_balance > 0) {
            $status = 3;
        } elseif ($updated_balance < 0) {
            $status = 1;
        }


        $supplier->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'start_balance' => $request->balance,
            'start_balance_status' => $request->balance_status,
            'balance' => $updated_balance,
            'balance_status' => $status

        ]);
        return redirect()->back()->with('success', 'تم تعديل المورد بنجاح ');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $supllier = supplier::find($request->id);
        if (count($supllier->invoice_supplier) > 0) {
            $this->error(' المورد له فواتير لا يمكن مسحه  ');
        }
        if ($supllier->balance!=0) {
            $this->error(' المورد له مستحقات  ');
        }
        $supllier->delete();
        return $this->success('تم الحذف بنجاح');
    }

    public function getStartBalance($id)
    {
        $total = 0;
        $supplier = supplier::find($id);
        foreach ($supplier->invoice_supplier as $invoice) {
            $total += $invoice->total - $invoice->payed;
        }
        return $supplier->balance - $total;
    }

    public function pay(Request $request)
    {
        $total = 0;
        $supplier = supplier::find($request->id);
        foreach ($supplier->invoice_supplier as $invoice) {
            return $total += $invoice->total - $invoice->payed;
        }

        $balance = $supplier->balance - $total;
        if ($request->payed > $balance) {
            return $this->error('البلغ اكبر من المستحق ');
        }
        $supplier->update(['balance' => $supplier->balance - $request->payed]);
        exchangeRevenue::create(['fk' => $supplier->id, 'amount' => -1 * $request->payed, 'type' => 1, 'com_code' => $supplier->com_code]);
        $safes = safe::where('com_code', $this->getAuthData('com_code'))->first();

        if ($safes->amount < $request->payed) {
            return $this->error('لا يوجد ما يكفي في الخزينه ');
        }
        $safes->update(['amount' => $safes->amount - $request->payed]);

        return $this->success('تم دفع النقدية بنجاح ');

    }
}
