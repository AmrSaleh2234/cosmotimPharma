<?php

namespace App\Http\Controllers;

use App\Models\exchangeRevenue;
use App\Models\invoice_customer;
use App\Models\order_customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class exchange extends Controller
{
    public function index()
    {
        $exchange = exchangeRevenue::where('com_code', $this->getAuthData('com_code'))->get();
        return view('reports.exchange', compact('exchange'));
    }

    public function products()
    {
        $products = order_customer::selectRaw(
            'sum(order_customers.quantity)  order_quantity ,inventories.product_id  product_id ,products.name name',

        )
            ->join('inventories', 'order_customers.inventory_id', '=', 'inventories.id')
            ->groupBy('product_id', 'name')
            ->join('products', 'product_id', '=', 'products.id')
            ->get();
        return view('reports.products', compact('products'));
    }

    public function productsSearchByDate(Request $request)
    {
        $request->validate([
            "firstDate" => "required",
            "secondDate" => "required",
        ]);
        if ($request->firstDate > $request->second) {
            $temp = $request->firstDate;
            $request->firstDate = $request->secondDate;
            $request->seccondDate = $temp;
        }

        $products = order_customer::
        selectRaw(
            ' sum(order_customers.quantity) order_quantity , products.name name ,inventories.product_id product_id  ')
            ->join('inventories', 'order_customers.inventory_id', '=', 'inventories.id')
            ->join('products', 'inventories.product_id', '=', 'products.id')->
            join('invoice_customers', 'order_customers.invoice_customer_id', '=', 'invoice_customers.id')
//            whereDate("invoice_customers.created_at", ">=", $request->firstDate)
//            ->whereDate("invoice_customers.created_at", "<=", $request->secondDate)
//            ->groupBy('product_id', "name")
            ->get();
        return view('reports.products', compact('products'));


    }
}
