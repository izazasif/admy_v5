@extends('portal.layouts.master')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Web API Checkout</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="{{route('web.api.purchase')}}">
                                            <button type="button" class="btn btn-primary btn-sm pull-right">
                                                <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;Buy Web API Packs
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

                                <div class="col-sm-8 text-center">
                                    <div class="col-sm-12" style="border: 2px solid #d4cfcf; padding: 10px;">
                                        <div class="pack-amount">
                                            <span>{{ $api->acquisition }} Acquisition</span>
                                        </div>
                                        <div class="pack-amount">
                                            <span>Total {{ $api->price }} Taka</span>
                                        </div>
                                        <div class="pack-buy">
                                            <button id="bKash_button" class="btn btn-md btn-flat btn-primary">
                                                Pay With bKash <img src="{{ asset('assets/admy/image/bkash.png') }}">
                                            </button>
                                        </div>
                                        <div style="font-weight: bold;">Note: Please be informed that your app will be broadcasted within 7 days based on available schedule.</div>
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
        var paymentID = '';
        var amount = '{{ $api->price }}';
        var user_package_id = '{{ $user_pack_id }}';
        var user_id = '{{ session()->get('') }}'
        var base_url = getBaseURL();
        bKash.init({
            paymentMode: 'checkout', //fixed value ‘checkout’
            //paymentRequest format: {amount: AMOUNT, intent: INTENT}
            //intent options
            //1) ‘sale’ – immediate transaction (2 API calls)
            //2) ‘authorization’ – deferred transaction (3 API calls)
            paymentRequest: {
                amount: '{{ $api->price }}', //max two decimal points allowed
                intent: 'sale'
            },
            createRequest: function(request) { //request object is basically the paymentRequest object, automatically pushed by the script in createRequest method
                $.ajax({
                    url: '{{ route('web-bkash-create-payment') }}',
                    type: 'POST',
                    data: JSON.stringify({
                        "amount":amount,
                        "user_web_api_id": user_package_id,
                    }),
                    contentType: 'application/json',
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data && data.paymentID != null) {
                            paymentID = data.paymentID;
                            bKash.create().onSuccess(data);
                        } else {
                            bKash.create().onError();
                        }
                    },
                    error: function() {
                        bKash.create().onError();
                    }
                });
            },
            executeRequestOnAuthorization: function() {
                $.ajax({
                    url: '{{ route('web-bkash-execute-payment') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "paymentID": paymentID,
                        "user_web_api_id": user_package_id,
                    }),
                    success: function(data) {
                        if(data) {
                            data = JSON.parse(data);
                            if (data && data.paymentID != null) {
                                window.location.href = "{{ url('web/bkash/success/') }}/"+paymentID;
                            } else {
                                // bKash.execute().onError();
                                window.location.href = "{{ url('web/bkash/error/') }}/"+data.errorCode;
                            }
                        }
                    },
                    error: function() {
                        // bKash.execute().onError();
                        window.location.href = "{{ url('web/bkash/error/') }}/"+data.errorCode;
                    }
                });
            }
        });
    </script>
@endsection
