@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Checkout</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="{{ route('pack.purchase') }}">
                                            <button type="button" class="btn btn-primary btn-sm pull-right">
                                                <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;Buy Packs
                                            </button>
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
                                        <ul class="text-left" style="list-style-type: none; padding-left: 0px;"><a
                                                class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            @foreach ($errors->all() as $error)
                                                <li><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                                    &nbsp;{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('message'))
                                    <div class="alert alert-success text-left">
                                        <ul style="list-style-type: none; padding-left: 0px;">
                                            <li>
                                                <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                &nbsp;{{ session('message') }}
                                            </li>
                                        </ul>
                                    </div>
                                @endif

                                <div class="col-sm-8 text-center">
                                    <div class="col-sm-12" style="border: 2px solid #d4cfcf; padding: 10px;">
                                        <div class="pack-name">
                                            {{ $packDetails->name }}
                                        </div>
                                        <div class="pack-price">
                                            {{ $packDetails->unit_price }} Taka
                                        </div>
                                        <div class="pack-amount">
                                            <span>{{ $packDetails->amount }} OBD</span>
                                        </div>
                                        <div class="pack-amount">
                                            <span>Total {{ $packDetails->price }} Taka</span>
                                        </div>
                                        <div class="pack-amount">
                                            <span>Vat({{ env('APP_PSMS_VAT') }}%)-
                                                {{ $packDetails->price * (env('APP_OBD_VAT') / 100) }}
                                                Taka</span>
                                        </div>
                                        {{-- payment gateway charge --}}
                                        <div class="pack-amount">
                                            <span>Gateway charge({{ env('APP_OBD_GATEWAY') }}%)-
                                                {{ $packDetails->price * (env('APP_OBD_GATEWAY') / 100) }} Taka</span>
                                        </div>
                                        <div class="pack-amount">
                                            <span>Sub-Total
                                                {{ $total_amount }}
                                                Taka</span>
                                        </div>
                                        <div class="pack-duration">
                                            <div>Call Duration</div>
                                            <div>max 0.29 minutes</div>
                                        </div>
                                        <div class="pack-validity">
                                            Validity: <b>{{ $packDetails->validity }} days</b>
                                        </div>
                                        <div class="pack-setup">
                                            Setup Charge: Free
                                        </div>
                                        <div class="pack-buy">
                                            {{-- @if (session()->get('user_id') == 1) --}}
                                            <button id="bKash_button" class="btn btn-md btn-flat btn-primary">
                                                <!-- <img src="{{ asset('assets/admy/image/bkash.png') }}" style="width: 100%;"> -->
                                                <!-- <div class="col-sm-8">Pay With bKash</div>  -->
                                                <!-- <div class="col-sm-4"> -->
                                                Pay With bKash <img src="{{ asset('assets/admy/image/bkash.png') }}">
                                                <!-- </div> -->
                                            </button>
                                            {{-- @endif --}}
                                        </div>
                                        <div style="font-weight: bold;">Note: Please be informed that your app will be
                                            broadcasted within 7 days based on available schedule.</div>
                                    </div>
                                </div>

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
@section('extra-foot-scripts')
    <script type="text/javascript">
        var packID = '{{ $packDetails->id }}';
        var amount = '{{ $total_amount }}';
        var paymentRequest;
        paymentRequest = {
            amount: amount,
            intent: 'sale'
        };

        $(document).ready(function() {
            var base_url = getBaseURL();
            // console.log('Grant Token Generated!');

            // console.log(JSON.stringify(paymentRequest));

            bKash.init({
                paymentMode: 'checkout',
                paymentRequest: paymentRequest,
                createRequest: function(request) {
                    // console.log('=> createRequest (request) :: ');
                    // console.log(request);

                    $.ajax({
                        url: base_url + "/payment/create?amount=" + paymentRequest.amount,
                        type: 'GET',
                        contentType: 'application/json',
                        success: function(data) {
                            // console.log('got data from create  ..');
                            // console.log('data ::=>');
                            // console.log(JSON.stringify(data));

                            var obj = JSON.parse(data);

                            if (data && obj.paymentID != null) {
                                paymentID = obj.paymentID;
                                bKash.create().onSuccess(obj);
                            } else {
                                // console.log('error');
                                bKash.create().onError();
                            }
                        },
                        error: function() {
                            // console.log('error');
                            bKash.create().onError();
                        }
                    });
                },

                executeRequestOnAuthorization: function() {
                    // console.log('=> executeRequestOnAuthorization');
                    $.ajax({
                        url: base_url + "/payment/execute?paymentID=" + paymentID + "&packID=" +
                            packID,
                        type: 'GET',
                        contentType: 'application/json',
                        success: function(data) {
                            // console.log('got data from execute  ..');
                            // console.log('data ::=>');
                            // console.log(JSON.stringify(data));

                            data = JSON.parse(data);
                            if (data && data.paymentID != null) {
                                // alert('[SUCCESS] data : ' + JSON.stringify(data));
                                window.location.href = base_url + "/payment/success";
                            } else {
                                // bKash.execute().onError();
                                window.location.href = base_url + "/payment/error/" + data
                                    .errorCode;
                            }
                        },
                        error: function() {
                            bKash.execute().onError();
                        }
                    });
                },

                onClose: function() {
                    console.log('iframe closed!');
                }
            });

            // console.log("Right after init ");
        });

        function clickPayButton() {
            $("#bKash_button").trigger('click');
        }
    </script>
@endsection
