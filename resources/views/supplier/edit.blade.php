@extends('layouts.master')
@section('title')
    تعديل مورد
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">تعديل/</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">$supplier->name</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row ">
        <div class="col-xl-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">تعديل مورد </h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>


                </div>
                <div class="card-body">
                    <form action="{{route('supplier.update',$supplier)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ادخل اسم المورد</label>
                                    <input type="text" class="form-control" name="name" value="{{$supplier->name}}">
                                </div>
                                <div class="form-group">
                                    <label>ادخل العنوان</label>
                                    <input type="text" class="form-control" name="address" value="{{ $supplier->address}}">
                                </div>


                            </div>
                            <div class="col-6">
                                <div  class="form-group">
                                    <label>ادخل رقم الهاتف</label>
                                    <input type="text" class="form-control" name="phone" value="{{$supplier->phone }}">


                                <div class="form-group">
                                    <label>حاله الحساب </label>
                                    <div class="row mg-t-10">
                                        <div class="col-lg-3">
                                            <label class="rdiobox"><input name="balance_status" type="radio" value="1" disabled >
                                                <span>مدين (عليه)</span></label>
                                        </div>
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox"><input name="balance_status"   type="radio" value="2" disabled >
                                                <span>متزن</span></label>
                                        </div>
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox"><input name="balance_status" type="radio" value="3" checked>
                                                <span>دائن (له)</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="balance" >
                                    <label>ادخل الرصيد</label>
                                    <input type="number" class="form-control" name="balance" value="{{ $supplier->start_balance }}">
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary w-25">حفظ</button>


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

        {{--$(document).ready(function () {--}}

        {{--    if({{$supplier->start_balance_status}} !=2)--}}
        {{--    {--}}
        {{--        $('#balance').css('display','block')--}}
        {{--    }--}}
        {{--    else{--}}
        {{--        $('#balance').css('display','none')--}}
        {{--    }--}}

        {{--    $('input[name="balance_status"]').on('change',function ()--}}
        {{--    {--}}
        {{--        if($(this).val()!=2)--}}
        {{--        {--}}
        {{--            $('#balance').css('display','block')--}}


        {{--        }--}}
        {{--        else--}}
        {{--        {--}}
        {{--            $('#balance').css('display','none')--}}
        {{--        }--}}

        {{--    })--}}
        {{--});--}}

    </script>
@endsection
