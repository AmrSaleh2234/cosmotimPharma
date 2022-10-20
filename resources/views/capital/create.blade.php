@extends('layouts.master')
@section('title')
    انشاء راس مال
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">راس مال</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ انشاء</span>
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
                        <h3 class="card-title mg-b-0">انشاء مورد </h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>


                </div>
                <div class="card-body">
                    <form action="{{route('capital.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ادخل اسم المورد</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>ادخل العنوان</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
                                

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ادخل رقم الهاتف</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>

                                <div class="form-group">
                                    <label>حاله الحساب </label>
                                    <div class="row mg-t-10">
                                        <div class="col-lg-3">
                                            <label class="rdiobox"><input name="balance_status" type="radio" value="1">
                                                <span>مدين (عليه)</span></label>
                                        </div>
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox"><input name="balance_status" checked  type="radio" value="2">
                                                <span>متزن</span></label>
                                        </div>
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox"><input name="balance_status" type="radio" value="3">
                                                <span>دائن (له)</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="balance" style="display: none">
                                    <label>ادخل الرصيد</label>
                                    <input type="number" class="form-control" name="balance">
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

        $(document).ready(function () {
            $('input[name="balance_status"]').on('change',function ()
            {
                if($(this).val()!=2)
                {
                    $('#balance').css('display','block')


                }
                else
                {
                    $('#balance').css('display','none')
                }

            })
        });

    </script>
@endsection
