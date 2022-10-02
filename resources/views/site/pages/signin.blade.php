@extends('site.layouts.master')

@section('content')
<div class="sign-up">
     <div class="container-fluid">
        <div class="row">
           <div class="col-md-10 col-md-offset-1">
                <h2 class="text-center">Sign In</h2>
           </div>
        </div>
     </div>
  </div>


  <div class="login-now">
     <div class="container-fluid">
         <!-- <div class="row"> -->
            <!-- <div class="col-md-10 col-md-offset-3"> -->
               <div class="row">

                  <!-- <div class="col-md-4 col-md-offset-1">
                     <img src="{{ asset('assets/images/top_address/logo_top.png') }}" class="img-responsive">
                  </div> -->

                  <div class="col-md-4 col-md-offset-4">
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
                       <form method="POST" action="{{ route('signin.submit') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                         <div class="form-group row">

                           <div class="col-xs-12">
                             <label for="email">Email:<span> *</span></label>
                             <input class="form-control input-lg" name="email" type="email">
                           </div>
                           <div class="col-xs-12">
                             <a href="{{ route('forgot') }}" class="pull-right forget-pass">Forgot Password?</a><label for="password">Password:<span> *</span> </label>
                             <input class="form-control input-lg" name="password" type="Password">
                           </div>
                           <div class="col-xs-12 text-center">
                              <button type="submit" class="btn btn-default btn-calculate">Sign in</button>
                              <p class="p1">New Customer? <b><a href="{{ route('signup') }}"><span class="sign-color">Sign Up</span></a></b></p>
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
