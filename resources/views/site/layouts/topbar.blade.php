<div class="logo-bar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('home') }}"> <img src="{{ asset('assets/images/top.png') }}" class="logo-image"></a>
            </div>
            <div class="col-md-8 bar-right-side">
                <div class="row">
                    <div class="col-md-7 col-xs-6 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-4 ">
                                <a href="{{ route('contact') }}#location-map" style="text-decoration: none;">
                                    <div class="media">
                                        <div class="media-left" style="padding-right: 3px;">
                                            <img src="{{ asset('assets/images/top_address/location_icon.png') }}" class="media-object" style="width: 24px;margin-top: -2px;">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading top-icon-text2">19/A, Banani, Dhaka.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-xs-4">
                                <!-- <a href="//api.whatsapp.com/send?phone=8801872634967" style="text-decoration: none;"> -->
                                <a href="#" style="text-decoration: none;">
                                    <div class="media" style="overflow: visible;">
                                        <div class="media-left" style="padding-right: 3px;">
                                            <img src="{{ asset('assets/images/top_address/whatsapp.png') }}" class="media-object" style="width:24px;">
                                        </div>
                                        <div class="media-body">
                                            <h6 class="top_contact"> Call Us </h6>
                                            <p class="media-heading top-icon-text"> +01843900056</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-xs-4 media1_image">
                                <a href="{{ route('contact') }}#contact-us-field" style="text-decoration: none;">
                                    <div class="media media1">
                                        <div class="media-left" style="padding-right: 3px;">
                                            <img src="{{ asset('assets/images/top_address/mail_icon.png') }}" class="media-object" style="width:24px;">
                                        </div>
                                        <div class="media-body">
                                            <h6 class="top_contact">Mail Us </h6>
                                            <p class="media-heading top-icon-text">support@mybdapps.com</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6 col-md-offset-1">
                        @if (session()->has('user_mail'))
                        @if (session()->get('user_role') == 'user')
                        <a href="{{ route('schedule.create') }}" class="btn btn-danger btn-calculate2" role="button">Portal</a>
                        @elseif(session()->get('permission') == 'sms_creator' || session()->get('permission') == 'sms_viewer' )
                        <a href="{{ route('sms.schedule.list') }}" class="btn btn-danger btn-calculate2" role="button">Portal</a>
                        @elseif(session()->get('permission') == 'financial')
                        <a href="{{ route('obd.bank.payment') }}" class="btn btn-danger btn-calculate2" role="button">Portal</a>
                        @elseif(session()->get('permission') == 'ticket')
                        <a href="{{ route('ticket.list') }}" class="btn btn-danger btn-calculate2" role="button">Portal</a>
                        @elseif(session()->get('permission') == 'report')
                        <a href="{{ route('report.user') }}" class="btn btn-danger btn-calculate2" role="button">Portal</a>
                        @elseif(session()->get('permission') == 'obd_creator' || session()->get('permission') == 'obd_sms_manager' || session()->get('permission') == 'obd_viewer' || session()->get('permission') == 'obd_sms_viewer')
                        <a href="{{ route('schedule.list') }}" class="btn btn-danger btn-calculate2"
                                    role="button">Portal</a>
                        @else
                        <a href="{{ route('dashboard.view') }}" class="btn btn-danger btn-calculate2" role="button">Portal</a>
                        @endif
                        <a href="{{ route('logout') }}" class="btn btn-danger btn-calculate2" role="button">Logout</a>
                        @else
                        <a href="{{ route('signin') }}" class="btn btn-danger btn-calculate2" role="button">SIGN
                            IN</a>
                        <a href="{{ route('signup') }}" class="btn btn-danger btn-calculate2" role="button">SIGN
                            UP</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<nav class="navbar navbar-inverse" data-offset-top="50">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav my-nav-left">
                <li><a href="{{ route('home') }}">Home</a></li>

                @if (!empty($condition) && $condition == 'in')
                <li><a href="#admy-obd-platform">OBD Platform</a></li>
                <li><a href="#push-sms-service">My Push SMS</a></li>
                <li><a href="{{ route('web-api') }}">Web API</a></li>
                <li><a href="#bulk-sms-service">Bulk SMS</a></li>
                <li><a href="#digital-platform">Digital Platform</a></li>
                <li><a href="#about-admy">About Us</a></li>
                @else
                <li><a href="{{ route('home') }}#admy-obd-platform">OBD Platform</a></li>
                <li><a href="{{ route('home') }}#push-sms-service">My Push SMS</a></li>
                <li><a href="{{ route('web-api') }}">Web API</a></li>
                <li><a href="{{ route('home') }}#bulk-sms-service">Bulk SMS</a></li>
                <li><a href="{{ route('home') }}#digital-platform">Digital Platform</a></li>
                <li><a href="{{ route('home') }}#about-admy">About Us</a></li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li style="margin-left: 38px;"><a href="{{ route('contact') }}">Contact Us</a></li>
                @if (session()->has('user_username'))
                <li><a href="#"><i class="fa fa-user"></i> {{ session()->get('user_username') }}</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
