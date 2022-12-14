<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\exchangeRevenue;
use App\Models\invoice_customer;
use App\Models\order_customer;
use App\Models\safe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if($request->balance_status==2)
        {
            $request->balance=0;
        }


        customer::create([
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'discount'=>$request->discount,
            'com_code'=>auth()->user()->com_code,
            'start_balance'=>$request->balance,
            'start_balance_status'=>$request->balance_status,
            'balance'=>$request->balance,
            'balance_status'=>$request->balance_status,
            'created_by' => $this->getAuthData('name'),
            'active' => 1


        ]);
        return redirect()->back()->with('success','تم اضافة العميل بنجاح ');


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
    public function edit(customer $customer)
    {
        return view('customer.edit', compact('customer'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $customer)
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

        $updated_balance = $customer->balance;
        foreach ($customer->invoice_customer as $invoice) {
            $total += $invoice->total - $invoice->payed;
        }
        $start_balance = $customer->balance - $total;// ely matbky mn start balance for sure he not exchange from customer
        $difr = $request->balance - $customer->start_balance;
        $updated_balance += $difr;
        if ($start_balance != $customer->start_balance) {
            return $this->error('لقد حصلت من العميل من قبل لا يمكن التعديل ');
        }

        $status = 2;
        if ($updated_balance > 0) {
            $status = 1;
        } elseif ($updated_balance < 0) {
            $status = 3;
        }


        $customer->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'start_balance' => $request->balance,
            'start_balance_status' => $request->balance_status,
            'balance' => $updated_balance,
            'balance_status' => $status,
            'updated_by' => $this->getAuthData('name'),
            'discount' => $request->discount

        ]);
        return redirect()->back()->with('success', 'تم تعديل المورد بنجاح ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $customer = customer::find($request->id);
        if (count($customer->invoice_customer) > 0) {
           return $this->error(' العميل  له فواتير لا يمكن مسحه  ');
        }

        if ($customer->balance!=$customer->start_balence) {
           return $this->error(' تم التحصيل من هذا العميل  ');
        }

        $customer->delete();
        return $this->success('تم الحذف بنجاح');
    }

    public function getStartBalance($id)
    {
        $total = 0;
        $customer = customer::find($id);
        foreach ($customer->invoice_customer as $invoice) {
            $total += $invoice->total_after - $invoice->payed;
        }
        return $customer->balance - $total;
    }

    public function collect(Request $request)
    {
        $total = 0;
        $customer = customer::find($request->id);

        foreach ($customer->invoice_customer as $invoice) {
             $total += $invoice->total_after - $invoice->payed;
        }

        $balance = $customer->balance - $total;  // start_balance
        if ($request->payed > $balance) {
            return $this->error('البلغ اكبر من المستحق ');
        }
        $status = 2;
        if ($customer->balance - $request->payed > 0) {
            $status = 1;
        } elseif ($customer->balance - $request->payed < 0) {
            $status = 3;
        }
        $customer->update(['balance' => $customer->balance - $request->payed,'balance_status' => $status]);
        exchangeRevenue::create(['fk' => $customer->id, 'amount' => ($request->payed), 'type' => 2, 'com_code' => $customer->com_code]);
        $safes = safe::where('com_code', $this->getAuthData('com_code'))->first();


        $safes->update(['amount' => $safes->amount + $request->payed]);

        return $this->success('تم دفع النقدية بنجاح ');

    }


    public function invoicesTable(customer $customer )
    {
        $invoiceByProducts =DB::table('order_customers')
                ->select('products.name as name' )
            ->join('invoice_customers', 'invoice_customers.id', '=', 'order_customers.invoice_customer_id')
        ->join('inventories', 'inventories.id', '=', 'order_customers.inventory_id')
            ->selectRaw('sum(order_customers.price_after_discount)  sum_price , sum(order_customers.quantity) sum_quantity ')
            ->groupBy('products.name')->join('products','inventories.product_id','products.id')
            ->get();



        return view('customer.invoices-table',compact('customer','invoiceByProducts'));
    }
}
