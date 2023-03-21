<div class="logo-bar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('assets/images/top-logo-new.png') }}" class="logo-image">
            </div>
            <div class="col-md-8 bar-right-side">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{ route('contact') }}#location-map">
                                    <div class="media">
                                        <div class="media-left">
                                            <img src="{{ asset('assets/images/top_address/location_icon.png') }}"
                                                class="media-object" style="width:30px">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading top-icon-text">19/A, Banani, Dhaka.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="//api.whatsapp.com/send?phone=8801872634967">
                                    <div class="media">
                                        <div class="media-left">
                                            <img src="{{ asset('assets/images/top_address/whatsapp.png') }}"
                                                class="media-object" style="width:30px">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading top-icon-text">Call Us +01872634967</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('contact') }}#contact-us-field">
                                    <div class="media">
                                        <div class="media-left">
                                            <img src="{{ asset('assets/images/top_address/mail_icon.png') }}"
                                                class="media-object" style="width:30px;">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading top-icon-text">Mail Us info@mybdapps.com</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-md-offset-1">
                        @if (session()->has('user_mail'))
                            @if (session()->get('user_role') == 'user')
                                <a href="{{ route('schedule.create') }}" class="btn btn-danger btn-calculate"
                                    role="button">Portal</a>
                            @elseif(session()->get('permission') == 'sms_creator' || session()->get('permission') == 'sms_viewer')
                                <a href="{{ route('sms.schedule.list') }}" class="btn btn-danger btn-calculate"
                                    role="button">Portal</a>
                            @else
                                <!-- <a href="{{ route('schedule.list') }}" class="btn btn-danger btn-calculate"
                                    role="button">Portal</a> -->
                                    <a href="{{ route('dashboard.view') }}" class="btn btn-danger btn-calculate"
                                    role="button">Portal</a>
                            @endif
                            <a href="{{ route('logout') }}" class="btn btn-danger btn-calculate"
                                role="button">Logout</a>
                        @else
                            <a href="{{ route('signin') }}" class="btn btn-danger btn-calculate" style="width:87%;" role="button">SIGN
                                IN</a>
                            <a href="{{ route('signup') }}" class="btn btn-danger btn-calculate" style="width:87%;" role="button">SIGN
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
                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                @if (session()->has('user_username'))
                    <li><a href="#"><i class="fa fa-user"></i> {{ session()->get('user_username') }}</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
