@extends('site.layouts.master')
@section('content')
    <div class="contact-us">
     <div class="container-fluid">
        <div class="row">
           <div class="col-md-10 col-md-offset-1">
                <h2 class="text-center">Contact Us</h2>
           </div>
        </div>
     </div>
  </div>
<div class="contact-us-field" id="contact-us-field">
     <div class="container-fluid">
         <div class="row">
            <div class="col-md-10 col-md-offset-1">
               <div class="row">

                  <div class="col-md-4 col-md-offset-1">
                     <div class="get-in-touch">
                        <h1 class="text-center in-touch">Get in Touch</h1>
                        <img src="{{ asset('assets/admy/image/rectangle-line.png') }}" class="line">
                        <div class="text-center">
                          <img src="{{ asset('assets/admy/image/message.png') }}" class="message">
                        </div>
                        <p style="line: height 1.4em;">Thank you for your time, pls. send anything (your questions, queries, feedback) to us. </p>
                        <p>We are listening...</p>
                     </div>
                  </div>

                  <div class="col-md-6" style="padding-left: 0px;padding-right: 0px;">
                    <div class="form-div">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                        <ul class="text-left" style="list-style-type: none; padding-left: 0px;"><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        @foreach ($errors->all() as $error)
                        <li style="font-weight: bold"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> {{ $error }}</li>
                        @endforeach
                        </ul>
                        </div>
                        @endif
                        @if (session('message'))
                        <div class="alert alert-success">
                        <ul class="text-left" style="list-style-type: none; padding-left: 0px;"><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <li style="font-weight: bold"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('message') }}</li>
                        </ul>
                        </div>
                        @endif
                       <form method="POST" action="{{ route('contact.submit') }}" enctype="multipart/form-data" class="form_con">
                        {{ csrf_field() }}
                         <div class="form-group row">

                           <div class="col-xs-12 margin-div">
                             <input class="form-control input-lg" name="name" value="{{ old('name') }}" type="text" placeholder="Your Name: *">
                           </div>
                           <div class="col-xs-12 margin-div">
                             <input class="form-control input-lg" name="email" value="{{ old('email') }}" type="email" placeholder="Email: *">
                           </div>
                           <div class="col-xs-12 margin-div">
                             <input class="form-control input-lg" name="subject" value="{{ old('subject') }}" type="text" placeholder="Subject: *">
                           </div>
                           <div class="col-xs-12">
                             <textarea class="form-control input-lg" name="message" rows="5" placeholder="Your Message: *">{{ old('message') }}</textarea>
                           </div>
                           <div class="col-xs-12 text-center">
                              <button type="submit" class="btn btn-default btn-calculate_2">Send Message</button>
                           </div>
                         </div>
                       </form>

                       <div class="row miaki-address">
                          <div class="col-md-2">
                                <img src="{{ asset('assets/images/contact-us/location.png') }}" class="contact-info-images1">
                          </div>
                          <div class="col-md-10">
                               <p>MyBDApps</p>
                               <p>Road # 19/A, House # 8</p>
                               <p>Banani, Dhaka, Bangladesh-1213</p>
                          </div>
                       </div>

                       <div class="row miaki-address">
                          <div class="col-md-2">
                                <img src="{{ asset('assets/images/contact-us/call.png') }}" class="contact-info-images2">
                          </div>
                          <div class="col-md-10">
                                 <p>+88 0187 2634 967</p>
                          </div>
                       </div>

                       <div class="row miaki-address">
                          <div class="col-md-2">
                                <img src="{{ asset('assets/images/contact-us/email.png') }}" class="contact-info-images3">
                          </div>
                          <div class="col-md-10">
                               <p>info@mybdapps.com</p>
                               <p>support@mybdapps.com</p>
                          </div>
                       </div>

                     </div>
                  </div>

               </div>

            </div>
         </div>
     </div>
  </div>



  <div class="location-map" id="location-map">
    <div class="container-fluid">
      <div class="row">
         <div class="col-md-12"
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.7682657346422!2d90.40721965102432!3d23.791264993054227!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7c6df560017%3A0x7d9d65d5ca4ee173!2sMiaki%20Media%20Ltd.!5e0!3m2!1sen!2sbd!4v1626176992969!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
         </div>
      </div>
    </div>
  </div>

@endsection
