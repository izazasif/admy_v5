@extends('portal.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Buy SMS Package</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div class="panel-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="text-left" style="list-style-type: none; padding-left: 0px;"><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            @foreach ($errors->all() as $error)
                                                <li><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> &nbsp;{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('message'))
                                    <div class="alert alert-success text-left">
                                        <ul style="list-style-type: none; padding-left: 0px;">
                                            <li>
                                                <a  class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> &nbsp;{{ session('message') }}
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                                <!-- <div class="col-sm-1"></div> -->
                                @foreach($sms as $sm)
                                    <div class="col-sm-2 text-center">
                                        <div class="col-sm-12" style="border: 2px solid #d4cfcf; padding: 10px;">
                                            <div class="pack-name">
                                                {{ $sm->name }}
                                            </div>
                                            <div class="pack-price">
                                                {{ $sm->unit_price }} Taka
                                            </div>
                                            <div class="pack-amount">
                                                <span>{{ number_format($sm->amount) }} SMS</span>
                                            </div>
                                            <div class="pack-amount">
                                                <span>Total {{ number_format($sm->price) }} Taka</span>
                                            </div>
                                            <div class="pack-validity">
                                                Validity: <b>{{ $sm->validity }} days</b>
                                            </div>
                                            <div class="pack-setup">
                                                Setup Charge: Free
                                            </div>
                                            <div class="pack-buy">
                                                <a class="btn btn-md btn-flat btn-primary" href="{{ route('sms.checkout', $sm->id) }}">Order Now</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
