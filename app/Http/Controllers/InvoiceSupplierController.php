<?php

namespace App\Http\Controllers;


use App\Models\exchangeRevenue;
use App\Models\invoice_supplier;
use App\Models\product;
use App\Models\safe;
use App\Models\supplier;
use Illuminate\Http\Request;

class InvoiceSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(supplier $supplier = null)
    {
        $invoices = invoice_supplier::where('com_code', $this->getAuthData('com_code'))->get();//com code required
        if ($supplier != null) {
            $invoices = $supplier->invoice_supplier;
            return view('supplier_invoice.index', compact('invoices', 'supplier'));

        }
        return view('supplier_invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(supplier $account)
    {
        $products = product::where('com_code', auth()->user()->com_code)->get();
        $data = [];
        foreach ($products as $product) {
            $product->total_quantity=0;
            if (count($product->inventory) > 0) {
                $sum = 0;
                foreach ($product->inventory as $inv) {
                    $sum += $inv->quantity;
                }
                $product->total_quantity = $sum;


            }

            array_push($data, $product);


        }

        return view('supplier_invoice.create', compact('account', 'data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, supplier $account)
    {
        $request->validate([
            "quantities"    => "required|array|min:1",
            "quantities.*"  => "required|numeric|min:1",
            "price"    => "required|array|min:1",
            "price.*"  => "required|numeric|min:1",
            "products_id"    => "required|array|min:1",
            "products_id.*"  => "required|numeric",
        ]);
        $i = 0;
        $id_invoice = 1;
        $total = 0;

        if (invoice_supplier::all()->last()) {
            $id_invoice = invoice_supplier::all()->last()->id + 1;
        }

        if ($account->com_code != $this->getAuthData('com_code')) {
            return $this->error('لا يسمح لك بالتحكم بهذا المورد');
        }

        foreach ($request->products_id as $id) {
            product::find($id)->inventory()->create([
                    'quantity' => $request->quantities[$i],
                    'price_before' => $request->price[$i] / $request->quantities[$i],
                    'created_by' => $this->getAuthData('name'),
                    'supplier_id' => $account->id,
                    'com_code' => $account->com_code]
            )->order_supplier()->create([
                'invoice_supplier_id' => $id_invoice
                , 'quantity' => $request->quantities[$i]
                , 'pricePerOne' => $request->price[$i] / $request->quantities[$i]
                , 'total' => $request->price[$i]
            ]);
            $total += $request->price[$i];
            $i++;

        }
        invoice_supplier::create([
            'id' => $id_invoice
            , 'supplier_id' => $account->id
            , 'total' => $total
            , 'payed' => 0
            , 'created_by' => $this->getAuthData('name')
            , 'com_code' => $account->com_code
        ]);
        $status = 2;
        if ($account->balance + $total > 0) {
            $status = 3;
        } elseif ($account->balance + $total < 0) {
            $status = 1;
        }


        $account->update(['balance' => $account->balance + $total, 'balance_status' => $status]);
        return $this->success('تم اضافة فاتورة المشتريات بنجاح ');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\invoice_supplier $invoice_supplier
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_supplier $invoice_supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\invoice_supplier $invoice_supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_supplier $invoice)
    {

        $products = product::where('com_code', auth()->user()->com_code)->get();
        $data = [];
        foreach ($products as $product) {

            if (count($product->inventory) > 0) {
                $sum = 0;
                foreach ($product->inventory as $inv) {
                    $sum += $inv->quantity;
                }
                $product->total_quantity = $sum;

                array_push($data, $product);
            }
        }

        return view('supplier_invoice.edit', compact('invoice', 'data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\invoice_supplier $invoice_supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_supplier $invoice)
    {
        $request->validate([
            "quantities"    => "required|array|min:1",
            "quantities.*"  => "required|numeric|min:1",
            "price"    => "required|array|min:1",
            "price.*"  => "required|numeric|min:1",
            "products_id"    => "required|array|min:1",
            "products_id.*"  => "required|numeric",
        ]);

        $id_invoice = $invoice->id;


        $status = 2;
        if ($invoice->payed >0)
        {
            return $this->error('لقد تم دفع جذء من الفاتورة ');
        }
        if ($invoice->supplier->balance - $invoice->total > 0) {
            $status = 3;
        } elseif ($invoice->supplier->balance - $invoice->total < 0) {
            $status = 1;
        }

        foreach ($invoice->inventory as $inv) {
            $inv->forceDelete();
        }
        $invoice->supplier->update(['balance' => $invoice->supplier->balance - $invoice->total, 'balance_status' => $status]);
        $invoice->order()->delete();


        $invoice->delete();

        $i = 0;
        $total = 0;


        foreach ($request->products_id as $id) {

            product::find($id)->inventory()->create([
                    'quantity' => $request->quantities[$i],
                    'price_before' => $request->price[$i] / $request->quantities[$i],
                    'created_by' => $this->getAuthData('name'),
                    'supplier_id' => $invoice->supplier->id,
                    'com_code' => $invoice->supplier->com_code]
            )->order_supplier()->create([
                'invoice_supplier_id' => $id_invoice
                , 'quantity' => $request->quantities[$i]
                , 'pricePerOne' => $request->price[$i] / $request->quantities[$i]
                , 'total' => $request->price[$i]
            ]);
            $total += $request->price[$i];
            $i++;

        }

        invoice_supplier::create([
            'id' => $id_invoice
            , 'supplier_id' => $invoice->supplier->id
            , 'total' => $total
            , 'payed' => 0
            , 'created_by' => $this->getAuthData('name')
            , 'com_code' => $invoice->supplier->com_code
        ]);
        $status = 2;
        if ($invoice->supplier->balance + $total > 0) {
            $status = 3;
        } elseif ($invoice->supplier->balance + $total < 0) {
            $status = 1;
        }


        $invoice->supplier->update(['balance' => $invoice->supplier->balance + $total, 'balance_status' => $status]);
        return $this->success('تم تعديل الفاتورة المشتريات بنجاح ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\invoice_supplier $invoice_supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_supplier $invoice)
    {
        if ($invoice->payed >0)
        {
            return $this->error('لقد تم دفع جذء من الفاتورة ');
        }
        $status = 2;
        if ($invoice->supplier->balance - $invoice->total > 0) {
            $status = 3;
        } elseif ($invoice->supplier->balance - $invoice->total < 0) {
            $status = 1;
        }

        foreach ($invoice->inventory as $inv) {
            $inv->forceDelete();
        }
        $invoice->supplier->update(['balance' => $invoice->supplier->balance - $invoice->total, 'balance_status' => $status]);
        $invoice->order()->delete();
        $invoice->delete();
        return $this->success('تم الحذف  بنجاح');
    }


    /*********************************created fun**************************************************/
    public function orderDetails(invoice_supplier $invoice)
    {

        return view('supplier_invoice._productOrder', compact('invoice'));

    }

    public function pay(Request $request)
    {
        $invoice = invoice_supplier::find($request->id);

        if ($invoice->com_code != $this->getAuthData('com_code')) {
            return $this->error('لا يمكن التعديل علي هذة اللفاتورة للمستخدم ');
        }
        if (($invoice->total-$invoice->payed) < $request->payed) {
            return $this->error('البلغ اكبر من قيمة الفاتورة المتبقية ');
        }

        $status = 2;
        if ($invoice->supplier->balance - $request->payed > 0) {
            $status = 3;
        } elseif ($invoice->supplier->balance - $request->payed < 0) {
            $status = 1;
        }

        $invoice->update(['payed' => $invoice->payed+$request->payed]);
        exchangeRevenue::create(['amount' => (-1 * $request->payed), 'type' => '3', 'com_code' => $invoice->supplier->com_code, 'fk' => $invoice->id]);
        $safe = safe::where('com_code', $invoice->com_code)->first();
        $safe->update(['amount' => $safe->amount - $request->payed]);
        $invoice->supplier->update(['balance' => $invoice->supplier->balance - $request->payed, 'balance_status' => $status]);
        return $this->success('تم تسجيل النقديه ');
    }

    public function payment(invoice_supplier $invoice)
    {
        if ($invoice->com_code != $this->getAuthData('com_code'))
        {
            return "غير ممسوح لك بعر المدفوعات ";
        }
        return view('customer_invoice._payment',compact('invoice'));
    }

    public function print(invoice_supplier $invoice)
    {
        return view('supplier_invoice.invoice',compact('invoice'));
    }

    public function searchDate($supplier = null, Request $request)
    {
        if ($request->firstDate == null && $request->secondDate == null) {
            return  redirect()->route('invoice_customer.index');
        }
        elseif ($request->firstDate == null || $request->secondDate == null) {
            return $this->error('لابد من ادخال التارخين معا اعد المحاوله ');
        }
        if ($request->secondDate < $request->firstDate) {
            $temp = $request->secondDate;
            $request->secondDate = $request->firstDate;
            $request->firstDate = $temp;
        }
        if ($supplier != -1 && $supplier != null) {
            $invoices = invoice_supplier::where('supplier_id',$supplier)->whereDate('created_at','>=', $request->firstDate)->whereDate('created_at','<=',$request->secondDate)->get();
            return view('supplier_invoice.index', compact('invoices', 'supplier'));

        } else {

            $invoices = invoice_supplier::where('com_code', $this->getAuthData('com_code'))->whereDate('created_at','>=', $request->firstDate)->whereDate('created_at','<=',$request->secondDate)->get();

            return view('supplier_invoice.index', compact('invoices'));
        }


    }
}
