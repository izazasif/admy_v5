@extends('site.layouts.master')

@section('content')
    <div class="slider-part">
        <div class="container-fluid">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">

                    <div class="item active">
                        <img src="{{ asset('assets/admy/image/banner2.jpeg') }}" alt="Los Angeles" style="width:100%;">
                        <div class="carousel-caption">
                            <h1 class="text-left"><b>Experts Services</b></h1>
                            <h2 class="text-left" style="font-size: 38px;"><b>To Change Your Business Value</b></h2>
                        </div>
                    </div>


                    <div class="item">
                        <img src="{{ asset('assets/admy/image/banner1.jpg') }}" alt="Los Angeles" style="width:100%;">
                        <div class="carousel-caption">
                            <h1 class="text-left"><b>Finding your best customers</b></h1>
                            <h2 class="text-left" style="font-size: 38px;"><b>and winning them over</b></h2>
                        </div>
                    </div>

                    <div class="item">
                        <img src="{{ asset('assets/admy/image/banner3.jpg') }}" alt="Los Angeles" style="width:100%;">
                        <div class="carousel-caption">
                            <h2 class="text-left" style="font-size: 38px;"><b>We are here to help you</b></h2>
                            <h1 class="text-left"><b>Business Solution</b></h1>
                            <h2 class="text-left" style="font-size: 38px;"><b>Potential Growth</b></h2>
                        </div>
                    </div>



                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>



    <div class="platform">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="row  background-red" style="margin-left: 51px!important;height: 198px!important;">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/banner_icon/obd_platform.png') }}" class="plat-image">
                                </div>
                                <div class="col-md-8">
                                    <h4 >OBD Platform</h4>
                                    <p>The system automatically dials out calls to a list of mobile users provided by the
                                        telecom operator.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="row background-red" style="margin-left: 51px!important;height: 198px!important;">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/banner_icon/bulk-sms-service.png') }}"
                                        class="plat-image">
                                </div>
                                <div class="col-md-8">
                                    <h4>BULK SMS Service</h4>
                                    <p>Use bulk SMS to raise brand awareness or just send SMS for your personal
                                        non-commercial needs.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <div class="row background-red" style="margin-left: 51px!important;height: 198px!important;">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/banner_icon/digital-platform.png') }}"
                                        class="plat-image">
                                </div>
                                <div class="col-md-8">
                                    <h4>DIGITAL Platform</h4>
                                    <p>Digital platforms allow for companies to pursue and create new business models that
                                        connect buyers and sellers.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <div class="row background-red" style="margin-left: 51px!important;height: 198px!important;">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/banner_icon/push-marketing.png') }}"
                                        class="plat-image">
                                </div>
                                <div class="col-md-8">
                                    <h4>PUSH Marketing</h4>
                                    <p>Push marketing is an interactive communication system, which pop-up on the handset’s
                                        screen & engage.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <br>

    <div class="about-admy" id="about-admy">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="row">
                        <div class="col-md-5">
                            <h2>About MyBDApps</h2>
                            <div class="row line-big">
                                <div class="col-md-12">
                                    <img src="{{ asset('assets/images/line/about_line.png') }}">
                                </div>
                            </div>
                            <div class="row line-sm">
                                <div class="col-md-12">
                                </div>
                            </div>
                            <p>MyBDApps is a digital marketing platform designed to promote products & services to the
                                community and target market. It is being developed to claim its spot as one of the top
                                digital marketing tools.
                                <br><br>Digital Marketing plays a big part in the success of any products & services of a
                                company, regardless of size, age or industry: that social media marketing is a must to
                                thrive in this digital era.
                                <br><br>With everything you need to promote your products & services in one place, you don't
                                have to pull yourself in many different directions. MyBDApps will help you to achieve
                                greater success.
                            </p>

                        </div>
                        <div class="col-md-7 text-right" data-aos="fade-left">
                            <img src="{{ asset('assets/admy/image/about.jpg') }}" style="width: 100%;margin-left: -3px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="product-overview">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div data-aos="fade-up" data-aos-duration="1000">
                        <h3 class="text-center"><b>Advantage of MyBDApps</b></h3>
                        <div class="row line-big">
                            <div class="col-md-12 text-center">
                                <img src="{{ asset('assets/images/line/advantage_line.png') }}">
                            </div>
                        </div>
                        <div class="row line-sm">
                            <div class="col-md-12 text-center">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="product-overview-bg flip-box-front">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/admy/image/shape1.png') }}">
                                        </div>
                                        <h5 class="text-center">ANALYTICS RESEARCH</h5>
                                    </div>
                                    <div class="flip-box-back">
                                        <!-- <h2>ANALYTICS RESEARCH</h2> -->
                                        <p class="flip-back-text">Holistic analytics about the whole community and target
                                            market. </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="product-overview-bg flip-box-front">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/admy/image/shape2.png') }}">
                                        </div>
                                        <h5 class="text-center">PROMOTE SERVICE</h5>
                                    </div>
                                    <div class="flip-box-back">
                                        <!-- <h2>AdMy</h2> -->
                                        <p class="flip-back-text">Efficient promotion leads to robust sell.</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="product-overview-bg flip-box-front">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/admy/image/shape3.png') }}">
                                        </div>
                                        <h5 class="text-center">ENSURE WEB TRAFFIC</h5>
                                    </div>
                                    <div class="flip-box-back">
                                        <!-- <h2>AdMy</h2> -->
                                        <p class="flip-back-text">Quality number of web traffic is confirmed.</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="product-overview-bg flip-box-front">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/admy/image/shape4.png') }}">
                                        </div>
                                        <h5 class="text-center">REQUIRED OBD TARGET</h5>
                                    </div>
                                    <div class="flip-box-back">
                                        <!-- <h2>AdMy</h2> -->
                                        <p class="flip-back-text">Availability of potential target insights.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="product-overview-bg flip-box-front">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/admy/image/shape5.png') }}">
                                        </div>
                                        <h5 class="text-center">CONTENT PLAN & CAMPAIGNS</h5>
                                    </div>
                                    <div class="flip-box-back">
                                        <!-- <h2>AdMy</h2> -->
                                        <p class="flip-back-text">Effective and target oriented masterpiece designing.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="product-overview-bg flip-box-front">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/admy/image/shape6.png') }}">
                                        </div>
                                        <h5 class="text-center">CONFIRM SUBSCRIBER</h5>
                                    </div>
                                    <div class="flip-box-back">
                                        <!-- <h2>AdMy</h2> -->
                                        <p class="flip-back-text">Business growth escalation through huge subscriber base.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="product-overview-bg flip-box-front">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/admy/image/shape7.png') }}">
                                        </div>
                                        <h5 class="text-center">VISIBILITY & INFLUENCE</h5>
                                    </div>
                                    <div class="flip-box-back">
                                        <!-- <h2>AdMy</h2> -->
                                        <p class="flip-back-text">Getting the up-to-date review of all the promotions.</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="product-overview-bg flip-box-front">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/admy/image/shape8.png') }}">
                                        </div>
                                        <h5 class="text-center">MEANINGFUL PLATFORMS</h5>
                                    </div>
                                    <div class="flip-box-back">
                                        <!-- <h2>AdMy</h2> -->
                                        <p class="flip-back-text">Financial boom through massive turnover.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="admy-obd-platform" id="admy-obd-platform">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="obd-heading">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/obd_platform_01/obd_platform.png') }}"
                                    class="img-responsive" data-aos="zoom-out">
                            </div>
                            <div class="col-md-8">
                                <h1 data-aos="fade-right">MyBDApps</h1>
                                <h2 data-aos="fade-left">OBD PLATFORM</h2>

                                <p class="first-p">With this platform OBD call is triggered to customer from a system
                                    offering different information like important voice broadcasting or services like VAS,
                                    promotional marketing sales or Customer Survey.</p>

                                <p class="second-p"><b>The main features of this system should be:</b> Self execution
                                    option for the customer should be easily configured (IVR system) and customized with 3rd
                                    party applications for different VAS services.</p>
                            </div>
                        </div>
                    </div>
                    <div class="detail">


                        <h4 class="text-center"><b>Key Benefits:</b></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <ul style="list-style-type:none">
                                    <li>Automatically dials mobile number subscribers to promote and market services.</li>
                                    <li>Intelligently segregates un-successful calls and re-dials automatically.</li>
                                    <li>Generates various reports.</li>
                                    <li>Supports virtually unlimited levels in call flow.</li>
                                    <li>Allows adding operator’s internal ‘Do not Dial (DND)’ list.</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul style="list-style-type:none">
                                    <li>Supports Call Patching, that is it routes IVR call to a customer support executive.
                                    </li>
                                    <li>Allows checking the quality of voice calls before initiating the dialling process.
                                    </li>
                                    <li>Allows defining dialling policies to call a particular list of numbers daily, weekly
                                        or monthly.</li>
                                    <li>Allows online and real-time activation and subscription process.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="obd-packages-plan">
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="obd-pack-plan text-center" data-aos="zoom-in">OBD PACKAGES PLAN</h2>
                    <div class="row" style="margin-left: 7%; margin-right: 7%;">
                    <div class="col-md-1 "></div> 
                        @foreach ($packs as $pack)
                            <div class="col-md-2">
                                <div class="wrap text-center " data-aos="zoom-in">
                                    <h3>{{ $pack->name }}</h3>
                                    <h2>{{ $pack->unit_price }} Taka</h2>
                                    <p class="p1">Call Duration <br>max 0.29 minutes</p>
                                    <p class="p1">Setup Charge: Free</p>
                                    <p class="p2" style="border-top: 1px solid #bbbebf;">
                                        {{ number_format($pack->amount) }} OBD</p>
                                    <p class="p2" style="border-top: 1px solid #bbbebf;">Total
                                        {{ number_format($pack->price) }} Taka</p>
                                    <p class="p2">Validity {{ $pack->validity }} days</p>

                                    <a href="{{ route('pack.checkout', $pack->id) }}"
                                        class="btn btn-danger btn-calculate" role="button">ORDER NOW</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="push-sms-service" id="push-sms-service">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <img src="{{ asset('assets/images/push_sms_03/my-push-smsm.png') }}" class="img-responsive">
                    <div class="global-delivery" data-aos="zoom-in" data-aos-duration="1000">
                        <h4 style="margin-left: -35px;"><b>Global reach and fast delivery</b></h4>
                        <img src="{{ asset('assets/images/line/push_line.png') }}" style="margin-left: -50px;" class="img-responsive">
                        <p style="margin-left: -54px;">Use bulk SMS to raise brand awareness or just send SMS for your personal non-commercial needs.
                            Automated SMS mailling reaches recipients at the speed of 200-500 SMS per second on 800 networks
                            in over 200 countries around the world.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="titles" style="margin-left: 70px;">
                        <h1 class="bulk">MY PUSH</h1>
                        <h1 class="sms-service">SMS SERVICE</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="service-process text-center" data-aos="fade-right" data-aos-duration="1000">
                                <b>Service Process</b>
                            </h3>
                            <img src="{{ asset('assets/images/push_sms_03/push-sms-service.png') }}"
                                class="img-responsive" data-aos="zoom-out" data-aos-duration="1000">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center bulk-plan"><b>MY PUSH SMS PRICE PLAN</b></h2>
                    <div class="" style="margin-left: 7%; margin-right: 7%;">
                       <!-- <div class="col-md-1"></div> -->
                        @foreach ($push_sms as $sm)
                            <div class="col-md-3 text-center" data-aos="zoom-out"
                                style=" padding-bottom:2%">
                                <div class="package">
                                    <h2>BDT {{ number_format($sm->price) }}</h2>
                                    <!-- <p> Per SMS</p> -->
                                    <h3><b>{{ number_format($sm->amount) }} SMS</b></h3>
                                    <b>Validity: {{ $sm->validity }} Day</b>
                                </div>
                                <a href="{{ url('sms/checkout', $sm->id) }}" class="btn btn-danger btn-calculate"
                                    role="button"><b>BUY NOW</b></a>
                            </div>
                        @endforeach
                        <!-- <div class="col-md-1"></div> -->
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="bulk-sms-service" id="bulk-sms-service">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-md-offset-1">
                    <img src="{{ asset('assets/images/bulk_sms_02/bulk_sms_service.png') }}" class="img-responsive">
                    <div class="global-delivery" data-aos="zoom-in" data-aos-duration="1000">
                        <h4 style="margin-left: -30px;"><b>Global reach and fast delivery</b></h4>
                        <img src="{{ asset('assets/images/line/bulk_line.png') }}" style="margin-left: -50px;" class="img-responsive">
                        <p style="margin-left: -55px;">Use bulk SMS to raise brand awareness or just send SMS for your personal non-commercial needs.
                            Automated SMS mailling reaches recipients at the speed of 200-500 SMS per second on 800 networks
                            in over 200 countries around the world.</p>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="titles">
                        <div class="row">
                            <div class="col-md-5">
                                <h1 class="bulk">BULK</h1>
                                <h1 class="sms-service">SMS SERVICE</h1>
                            </div>
                            <div class="col-md-2">
                                <img class="coming_soon" src="{{ asset('assets/images/banner_icon/coming-soon.png') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10" style="margin-top:165px;">
                            <h3 class="service-process text-center" data-aos="fade-right" data-aos-duration="1000">
                                <b>Service Process</b>
                            </h3>
                            <img src="{{ asset('assets/images/bulk_sms_02/bulk-sms-infographic.png') }}"
                                class="img-responsive" data-aos="zoom-out" data-aos-duration="1000">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center bulk-plan"><b>BULK SMS PRICE PLAN</b></h2>
                    <div class="row">
                        <div class="col-md-1"></div>
                        @foreach ($sms as $sm)
                            <div class="col-md-2 text-center" data-aos="zoom-out">
                                <div class="package">
                                    <h2>{{ $sm->unit_price }} BDT</h2>
                                    <p> {{ $sm->amount }} SMS</p>
                                    <h3>{{ $sm->validity }} Days</h3>
                                    <p>({{ $sm->sms_type }} SMS)</p>
                                </div>
                                <a href="#" class="btn btn-danger btn-calculate" role="button"><b>Coming
                                        Soon</b></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="digital-platform" id="digital-platform">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 col-md-offset-1 image">
                    <div class="title">
                        <h1 class="digital" data-aos="fade-right">DIGITAL</h1>
                        <h1 class="platforms" data-aos="fade-left">PLATFORM</h1>
                    </div>
                    <img src="{{ asset('assets/images/digital_platform/digital-platform.png') }}" class="img-responsive"
                        data-aos="zoom-out">

                </div>
                <div class="col-md-10 col-md-offset-1 content-digital">
                    <h5><b>Digital excellence require platform thinking. How does a digital version of your business look?
                            We help you to create it through our expertise in architecture and digital platforms.</b></h5>

                    <p>Key attributes for a digital enterprise include intentional and beautiful design, value for both
                        customer and business, part of your ecosystem of value, delivering with speed and quality. We help
                        modernize your legacy systems to better cope with the speed of technology change, making sure that
                        you, securely, can participate in new digital ecosystems with your data and APIs.</p>


                    <h5><b>Our Services:</b></h5>
                    <p>We are enabler as you create and update your digital platforms in, or outside of the cloud. We offer:
                    </p>

                    <h5><b>Solutioning:</b></h5>
                    <p>Digital platform expertise; showing how to make touch points move faster than back-end systems.</p>

                    <h5><b>Design:</b></h5>
                    <p>Managing service design, UX, design thinking and experiments.
                </div>

                <div class="col-md-5 col-md-offset-1 content-digital-left">
                    <h5><b>implementation:</b></h5>
                    <p>Managing services, master data, standards and platforms.</p>
                    <h4><b>Cost per acquisition is also referred to as cost per action or CPA — but don’t get confused with
                            diction, these three terms all mean the same thing!</b></h4>
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('assets/images/digital_platform/cpc.png') }}" class="cpa-image">
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="admyModal" role="dialog">
        <div class="modal-dialog modal-lg" style="margin-top: 120px">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"
                            aria-hidden="true"></i></button>
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <a href="{{ route('signup') }}">
                        <img src="{{ asset('assets/admy/image/popup3.jpg') }}" class="img-responsive"
                            style="padding-top: 10px;">
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#admyModal">Quiz Modal</button> -->
@endsection


@section('extra-foot-scripts')
    {{-- <script> --}}
    {{--    // :::::: admyModal modal ::::: --}}
    {{--        function admyModal(){ --}}
    {{--          setTimeout( function(){$('#admyModal').modal('show')}); --}}
    {{--        } --}}
    {{--        admyModal(); --}}

    {{--        setTimeout(function(){ --}}
    {{--            $('#admyModal').modal('hide'); --}}
    {{--        }, 10000); --}}
    {{-- </script> --}}
@endsection
