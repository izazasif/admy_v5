@extends('site.layouts.master')
@section('content')
    <div class="contact-us">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h2 class="text-center">Purchase Plan</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-us-field">
        <div class="container-fluid">
            <div class="row">
                <div class="text-center">
                    <img class="coming_soon" src="{{ asset('assets/images/banner_icon/coming-soon.png') }}">
                </div>
                <h2 class="text-center bulk-plan web-plan"><b>WEB API PRICE PLAN</b></h2>
                <div class="col-md-7">
                    <div class="row">
                            <div class="row" id="web-api-service">
                                <div class="col-md-2"></div>
                                @foreach($packs as $pack)
                                    <div class="col-md-3 text-center" data-aos="zoom-out">
                                        <div class="api-package">
                                           <h2>BDT {{ $pack->price }}</h2>
                                           <p> {{ $pack->acquisition }} ACQUISITION</p>
                                        </div>
                                        <!-- <a href="{{ url('web/api/checkout',$pack->id) }}" class="btn btn-danger btn-calculate" role="button"><b>BUY NOW</b></a> -->
                                        <a href="#" class="btn btn-danger btn-calculate" role="button"><b>Coming Soon</b></a>
                                    </div>
                                @endforeach
                            </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row" id="web-api-service_c">
                    <div class="col-md-11">
                        <form id="custom" action="{{ route('web.api.checkout.post') }}" method="POST">
                            @csrf
                        <div class="api-package_2">

                            <h2> Choose Your Plan</h2>
                                <table>
                                    <tr>
                                        <td><p>ACQUISITION </p></td>
                                        <td><input  name="acquisition" id="acquisition" value="0" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td><p style="margin-top: 15px">COST</p></td>
                                        <td><button style="width: 100%; margin-top: 15px" class="btn btn-danger btn-calculate" id="ts">0</button></td>
                                    </tr>
                                </table>
                        </div>
                        <!-- <button  class="btn btn-danger btn-calculate" type="submit" style="width: 100%" role="button"><b>BUY NOW</b></button> -->
                        <button  class="btn btn-danger" type="button" style="width: 100%" role="button"><b>Coming Soon</b></button>
                        </form>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-foot-scripts')
    <script>
        $("#acquisition").keyup( function (){
            var total = 0;
            var ac = $("#acquisition").val();
            var unit_price = {{ $unit_price }};
            total = ac*unit_price;
            $("#ts").text(total)
        });
    </script>
@endsection
