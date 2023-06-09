@extends('portal.layouts.master')
<style>
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 10px;
    }

    label.custom-file-upload {
        cursor: pointer;
        border: 2px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 4px;
        margin-bottom: 10px;
        transition: all 0.2s ease-in-out;
    }

    label.custom-file-upload:hover {
        background-color: #ccc;
    }

    input[type="file"] {
        display: none;
    }
</style>
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">SMS Checkout</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="{{ route('sms.purchase') }}">
                                            <button type="button" class="btn btn-primary btn-sm pull-right">
                                                <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;Buy SMS Packs
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

                                <div class="col-md-8 text-center">
                                    <div style="border: 2px solid #d4cfcf; padding: 10px;">
                                        <div class="pack-name">
                                            {{ $packDetails->name }}
                                        </div>
                                        <div class="pack-price">
                                            {{ $packDetails->unit_price }} Taka
                                        </div>
                                        <div class="pack-amount">
                                            <span>{{ $packDetails->amount }} SMS</span>
                                        </div>
                                        <div class="pack-amount">
                                            <span>Total
                                                {{ $packDetails->price }} Taka</span>
                                        </div>
                                        {{-- vat charge --}}
                                        <div class="pack-amount">
                                            <span>Vat({{ env('APP_PSMS_VAT') }}%)-
                                                {{ $packDetails->price * (env('APP_PSMS_VAT') / 100) }}
                                                Taka</span>
                                        </div>
                                        {{-- payment gateway charge --}}
                                        <div class="pack-amount">
                                            <span>Gateway charge({{ env('APP_PSMS_GATEWAY') }}%)-
                                                {{ $packDetails->price * (env('APP_PSMS_GATEWAY') / 100) }} Taka</span>
                                        </div>
                                        <div class="pack-amount">
                                            <span>Sub-Total
                                                {{ $total_amount }}
                                                Taka</span>
                                        </div>
                                        <div class="pack-validity">
                                            Validity: <b>{{ $packDetails->validity }} days</b>
                                        </div>
                                        <div class="pack-setup">
                                            Setup Charge: Free
                                        </div>
                                        <div class="pack-buy">
                                            <button id="bKash_button" class="btn btn-md btn-flat btn-primary">
                                                Pay With bKash <img src="{{ asset('assets/admy/image/bkash.png') }}">
                                            </button>
                                        </div>
                                        <h4>OR</h4>
                                        <div class="pack-buy">
                                            <p>Pay With Payment Slip</p>
                                            <form method="POST" action="{{ route('payslip.pushsms.store') }}"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <label for="image-upload" class="custom-file-upload">
                                                    <i class="fa fa-cloud-upload"></i> Choose Image
                                                </label>
                                                <input value={{ $packDetails->id }} name='sms_id' type='hidden' />
                                                <input readonly id="image-upload" name="slip"
                                                    style="border: 2px solid black" type="file"
                                                    accept="image/jpeg,image/png" required>
                                                <button style="margin-top: 10px" type="submit"
                                                    class="btn btn-md btn-flat btn-primary">
                                                    Submit
                                                </button>
                                            </form>
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
        var paymentID = '';
        var amount = '{{ $total_amount }}';
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
                amount: '{{ $total_amount }}', //max two decimal points allowed
                intent: 'sale'
            },
            createRequest: function(
                request
            ) { //request object is basically the paymentRequest object, automatically pushed by the script in createRequest method
                $.ajax({
                    url: '{{ route('bkash-create-payment') }}',
                    type: 'POST',
                    data: JSON.stringify({
                        "amount": amount,
                        "user_sms_id": user_package_id,
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
                    url: '{{ route('bkash-execute-payment') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "paymentID": paymentID,
                        "user_sms_id": user_package_id,
                    }),
                    success: function(data) {
                        if (data) {
                            data = JSON.parse(data);
                            if (data && data.paymentID != null) {
                                window.location.href = "{{ url('bkash/success/') }}/" + paymentID;
                            } else {
                                // bKash.execute().onError();
                                window.location.href = "{{ url('bkash/error/') }}/" + data
                                    .errorCode;
                            }
                        }
                    },
                    error: function() {
                        // bKash.execute().onError();
                        window.location.href = "{{ url('bkash/error/') }}/" + data.errorCode;
                    }
                });
            }
        });
    </script>
@endsection
