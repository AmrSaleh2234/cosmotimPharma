<?php

namespace App\Http\Controllers;


use App\Models\invoice_supplier;
use App\Models\product;
use App\Models\supplier;
use Illuminate\Http\Request;

class InvoiceSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoice_supplier::where('com_code', $this->getAuthData('com_code'))->get();//com code required
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

            if (count($product->inventory) > 0) {
                $sum = 0;
                foreach ($product->inventory as $inv) {
                    $sum += $inv->quantity;
                }
                $product->total_quantity = $sum;

                array_push($data, $product);
            }


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

        $id_invoice = $invoice->id;


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
}
