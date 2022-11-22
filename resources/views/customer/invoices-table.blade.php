@extends('layouts.master')
@section('title')
    عرض فواتير المبيعات
@endsection
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">العملاء </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/فواتير
                    المبيعات </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    {{--    @if(isset($customer))--}}
    {{--        <a class="btn btn-primary" href="{{route('customer.invoicesInTable',$customer)}}">رؤية عامة للعميل </a>--}}
    {{--    @endif--}}

    <div class="row d-flex flex-wrap">
        <div class="col-lg-6 col-sm-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">فواتير المبيعات</h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="card-body" id="print_invoices_details">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th class="">رقم الفاتورة</th>
                                    <th class="">اسم المنتج</th>
                                    <th class="">الكميه</th>
                                    <th class="">السعر</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=1;
                                    $total=0;

                                @endphp
                                @foreach($customer->invoice_customer as $item)
                                    <tr>
                                        <td rowspan="{{count($item->order)+2}}" style="position: relative;border: 2px solid #673ab7;">
                                            <div class="d-flex justify-content-center align-items-center text-primary"
                                                 style="position: absolute;top:0;left: 0; height: 100%;width: 100%;">
                                                {{$item->id}}
                                            </div>
                                        </td>

                                        @foreach($item->inventory as $order)
                                            @if($i==1)
                                                <td>{{$order->product->name}}</td>
                                                <td>{{$order->pivot->quantity}}</td>
                                                <td>{{$order->pivot->price_after_discount}}</td>
                                    </tr>
                                    @else
                                        <tr>
                                            <td>{{$order->product->name}}</td>
                                            <td>{{$order->pivot->quantity}}</td>
                                            <td>{{$order->pivot->price_after_discount}}</td>
                                        </tr>

                                    @endif

                                    @php
                                        ++$i;
                                        $total+=$order->pivot->price_after_discount;

                                    @endphp
                                @endforeach
                                <tr class="text-purple" style="border: 1px solid">

                                    <td style="border: 1.7px solid #673ab7;"> الاجمالي</td>
                                    <td style="border-top: 1.7px solid #673ab7;border-bottom: 1.7px solid #673ab7;border-left: 1.7px solid #673ab7;"> المدفوع</td>
                                    <td style="border-top: 1.7px solid #673ab7;border-bottom: 1.7px solid #673ab7;border-left: 1.7px solid #673ab7;"> الغير مدفوع</td>
                                </tr>
                                <tr>
                                    <td style="border: 1.7px solid #673ab7; ;position: relative">
                                        <div class="d-flex justify-content-center align-items-center"
                                             style="position: absolute;top: 0;left: 0; height: 100%; width: 100%;">
                                            {{$item->total_after}}
                                        </div>
                                    </td>
                                    <td class="text-success" style="border: border-top: 1.7px solid #673ab7;border-bottom: 1.7px solid #673ab7;border-left: 1.7px solid #673ab7; ">{{$item->payed}}</td>
                                    <td class="text-danger"
                                        style="border-top: 1.7px solid #673ab7;border-bottom: 1.7px solid #673ab7;border-left: 1.7px solid #673ab7 ; ">{{$item->total_after-$item->payed}}</td>

                                </tr>

                                @php
                                    $i=1 ;
                                @endphp

                                @endforeach
                                <tr class="text-orange">
                                    <td colspan="3" style="border: 2px solid;border-top: none ">مجموع الفواتير الكلي
                                    </td>
                                    <td style="border: 2px solid;border-top: none; border-right: none;"> {{$total}}</td>
                                </tr>

                                </tbody>
                            </table>

                        </div>

                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary-gradient w-50 mb-3" onclick="print_invoices()">اطبع</button>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">الفاتورة</h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>

                    <div class="card-body" id="print-products">


                        <div class="table-responsive">
                            <table id="" class="table">
                                <thead>
                                <tr>

                                    <th class="">اسم المنتج</th>
                                    <th class="">الكميه</th>
                                    <th class="">السعر</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoiceByProducts as $product)
                                    <tr>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->sum_quantity}}</td>
                                        <td>{{$product->sum_price}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary-gradient w-50 mb-3" onclick="print_products()">اطبع</button>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/js/print.js') }}"></script>
    <script>
        function print_invoices()
        {
            $('#print_invoices_details').printThis();

        }
    </script>
    <script>
        function print_products()
        {

            $('#print-products').printThis();

        }
    </script>

@endsection

