@extends('site.layouts.master')

@section('content')

<div class="sign-up">
     <div class="container-fluid">
        <div class="row">
           <div class="col-md-10 col-md-offset-1">
                <h2 class="text-center">Sign Up</h2>
           </div>
        </div>
     </div>
  </div>
<div class="registration-now">
     <div class="container">
               <div class="row form-div">
                   <div class="col-md-2  sign-up-background">
                       <h2 class="text-center reg_text">Registration<br> Now</h2>
                   </div>
                  <div class="col-md-8">
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
                       <form method="POST" action="{{ route('signup.submit') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                         <div class="form-group row">
                             <div class="col-md-6 col-sm-6 col-xs-6">
                                 <label for="username">First Name:<span> *</span></label>
                                 <input class="form-control input-lg" name="first_name" value="{{ old('first_name') }}" type="text">
                             </div>
                             <div class="col-md-6 col-sm-6 col-xs-6">
                                 <label for="username">Last Name:<span></span></label>
                                 <input class="form-control input-lg" name="last_name" value="{{ old('last_name') }}" type="text">
                             </div>
                           <div class="col-md-12 col-sm-12 col-xs-12">
                             <label for="email">Email:<span> *</span></label>
                             <input class="form-control input-lg" name="email" value="{{ old('email') }}" type="email">
                           </div>
                           <div class="col-md-12 col-sm-12 col-xs-12">
                             <label for="password">Password:<span> *</span></label>
                             <input class="form-control input-lg" name="password" type="password">
                           </div>
                           <div class="col-md-12 col-sm-12 col-xs-12">
                             <label for="confirm_password">Confirm Password:<span> *</span></label>
                             <input class="form-control input-lg" name="confirm_password" type="password">
                           </div>
                           <div class="col-md-12 col-sm-12 col-xs-12">
                             <label for="mobile_no">Mobile Number:<span> *</span></label>
                             <input class="form-control input-lg" name="mobile_no" value="{{ old('mobile_no') }}" type="number">
                           </div>
                           <div class="col-xs-12 text-center">
                              <button type="submit" class="btn btn-default btn-calculate_2">Signup</button>
                              <p class="p1"><b>By clicking on sign up, you agree to  our</b></p>
                              <p class="p2"><b><a href="{{ route('privacy') }}">Privacy policy & Terms and conditions</a></b></p>
                           </div>
                         </div>
                       </form>
                     </div>
                  </div>

               </div>

            <!-- </div> -->
         <!-- </div> -->
     </div>
  </div>

@endsection
