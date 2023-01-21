@extends('layouts.master')
@section('title')
    تعديل فاتورة مبيعات
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">العميل : {{ $invoice->customer->name }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row d-flex flex-wrap">
        <div class="col-lg-6 col-sm-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">المنتجات</h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                $i = 0;
                            @endphp
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم المنتج</th>
                                        <th>السعر</th>
                                        <th>الكمية </th>
                                        <th>اضافة</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td scope="row">{{ ++$i }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price_after }}</td>
                                            <td>{{ $item->total_quantity }}</td>
                                            <td>
                                                <a>
                                                    <button class="btn btn-success btn-icon add-product-btn"
                                                        data-name="{{ $item->name }}"
                                                        data-price="{{ $item->price_after }}" data-id="{{ $item->id }}"
                                                        id="product-{{ $item->id }}"><i
                                                            class="typcn typcn-document-add "></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

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
                    <form action="{{ route('invoice_customer.update', $invoice) }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mg-b-0 text-md-nowrap">
                                    <thead>
                                        <tr>

                                            <th>اسم المنتج</th>
                                            <th>الكمية</th>
                                            <th>خصم</th>
                                            <th>السعر</th>
                                            <th>حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">

                                        @foreach ($invoice->inventory as $item)

                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td class="quantity">
                                                    <input type="hidden" name="products_id[]"
                                                        value="{{ $item->product->id }}">
                                                    <input class="input-sm quantity_input"
                                                        value="{{ $item->pivot->quantity }}" name="quantities[]"
                                                        data-price="{{$item->product->price_after}}" type="number"
                                                        min="1" style="width: 60px">
                                                </td>
                                                <td class="discount">
                                                    <input type="number" min="0" max="100" step="any" style="width: 49px"
                                                        value="{{ $item->pivot->discount }}" class="discount_input"
                                                        name="discount[]">

                                                </td>
                                                <td class="product_price">
                                                    {{ $item->pivot->price_after_discount }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-icon btn-delete-product"
                                                        data-id="{{ $item->product->id }}"><i
                                                            class="typcn typcn-document-delete "></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <hr>

                            <div class="mt-4 d-flex justify-content-center">
                                <label class="ml-3">خصم علي الفاتورة ككل</label>
                                <input class="enableByJs" type="number" value="0" min="0" max="100"
                                    disabled name="invoice_discount" id="discount_invoice">
                            </div>
                            <div class="mt-3">
                                <span>المجموع: </span> <span id="total">{{$invoice->total_after}}</span>
                            </div>

                            <div class="text-center">
                                <button type="submit" disabled class="btn btn-primary mt-3  enableByJs" id="order_customer"
                                    style="width: 32%">
                                    احفظ
                                </button>
                            </div>
                        </div>
                    </form>


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
    <script>
        $(document).ready(function() {
            if ($("#tbody").children().length != 0) {
                    $('.enableByJs').prop('disabled', false)
                }
            $('.add-product-btn').on('click', function(e) {
                e.preventDefault();
                var button = $(this)
                var name = button.data('name');
                var id = button.data('id');
                var price = button.data('price');
                var html = '<tr> <td>' + name + '</td><td class="quantity">' +
                    '<input type="hidden" name="products_id[]" value= "' + id + '"> ' +
                    '<input class="input-sm quantity_input" value="1" data-price="' + price +
                    '" type="number" min ="1"  name="quantities[]" data-price ="' + price +
                    '"style="width:60px">' +
                    '</td><td class="discount"><input type ="number" min="0" max="100" step="any" style="width:49px" value ="{{ $invoice->customer->discount }}" class="discount_input" name="discount[]" ></td><td class="product_price" >' +
                    price +
                    '</td><td><button class="btn btn-danger btn-icon btn-delete-product" data-id = "' + id +
                    '"><i class="typcn typcn-document-delete "></i></button></td> </tr>';
                $('.enableByJs').prop('disabled', false)
                $('#tbody').append(html);
                calculateDiscount()
                calculateTotal();
                button.addClass('disabled ');
            });
            $('body').on('click', '.btn-delete-product', function(e) {
                e.preventDefault();
                var button = $(this)
                var id = button.data('id');
                $('#product-' + id).removeClass('disabled');
                button.closest('tr').remove();
                if ($("#tbody").children().length == 0) {
                    $('.enableByJs').prop('disabled', true)
                }
                calculateTotal();
            });
            $('body').on('keyup change', '.quantity_input', function(e) {

                // var val=Number(productPrice.data('price'));
                var quantity = $(this).val();
                var price = $(this).data('price');
                var val = quantity * price
                var discount = Number($(this).closest('tr').find('.discount input').val());
                discount /= 100;
                discount = val * discount;
                $(this).closest('tr').find('.product_price').html(val - discount);
                calculateTotal()

            })
            $('body').on('keyup change', '.discount_input', function(e) {

                var quantity = $(this).closest('tr').find('.quantity .quantity_input');
                var discount = $(this).val();
                var price = quantity.data('price');

                var val = Number(quantity.val()) * price

                discount /= 100;
                discount = val * discount;
                $(this).closest('tr').find('.product_price').html(val - discount);
                calculateTotal()

            });
            $('body').on('keyup change', '#discount_invoice', function(e) {
                calculateTotal()
            })
        });



        function calculateDiscount() {
            $('#tbody .discount_input').each(function(index) {

                var quantity = $(this).closest('tr').find('.quantity .quantity_input');
                var discount = $(this).val();
                var price = quantity.data('price');

                var val = Number(quantity.val()) * price

                discount /= 100;
                discount = val * discount;
                $(this).closest('tr').find('.product_price').html(val - discount);


            })
        }

        function calculateTotal() {
            var price = 0;
            $('#tbody .product_price').each(function(index) {
                price += Number($(this).html());
            })

            var discount = $('#discount_invoice').val() / 100;
            price -= price * discount;
            $('#total').html(price)
        }
    </script>
@endsection
