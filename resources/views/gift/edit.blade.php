@extends('layouts.master')
@section('title')
    تعديل فاتورة الهدايا
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                class="text-muted mt-1 tx-13 mr-2 mb-0"> تعديل الهدايا</span>
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
                                        <th>الكمية </th>
                                        <th>اضافة</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td scope="row">{{ ++$i }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->total_quantity }}</td>
                                            <td>
                                                <a>
                                                    <button class="btn btn-success btn-icon add-product-btn"
                                                        data-name="{{ $item->name }}" data-id="{{ $item->id }}"
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
                    <form action="{{ route('gift.update', $invoice) }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mg-b-0 text-md-nowrap">
                                    <thead>
                                        <tr>

                                            <th>اسم المنتج</th>
                                            <th>الكمية</th>
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
                                                        type="number"
                                                        min="1" style="width: 60px">
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
        
                var html = '<tr> <td>' + name + '</td><td class="quantity">' +
                    '<input type="hidden" name="products_id[]" value= "' + id + '"> ' +
                    '<input class="input-sm quantity_input" value="1" type="number" min ="1"  name="quantities[]" style="width:60px">' +
                    '</td><td><button class="btn btn-danger btn-icon btn-delete-product" data-id = "' + id +
                    '"><i class="typcn typcn-document-delete "></i></button></td> </tr>';
                $('.enableByJs').prop('disabled', false)
                $('#tbody').append(html);
        
                button.addClass('disabled ').prop('disabled',true);
            });
            $('body').on('click', '.btn-delete-product', function(e) {
                e.preventDefault();
                var button = $(this)
                var id = button.data('id');
                $('#product-' + id).removeClass('disabled').prop('disabled',false);
                button.closest('tr').remove();
                if ($("#tbody").children().length == 0) {
                    $('.enableByJs').prop('disabled', true)
                }
                
            });  
        });



        
    </script>
@endsection
