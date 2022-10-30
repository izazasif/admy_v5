@extends('portal.layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-sm-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Buy Packs</h3>

            <div class="box-tools">
              <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                <div class="input-group-btn">
                  <a href="">
                    <!-- <button type="button" class="btn btn-primary btn-sm pull-right">
                      <i class="fa fa-users" aria-hidden="true"></i> All Categories
                    </button> -->
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
              <!-- <div class="col-sm-1"></div> -->
              @foreach($packs as $pack)
              <div class="col-sm-2 text-center">
                <div class="col-sm-12" style="border: 2px solid #d4cfcf; padding: 10px;">
                  <div class="pack-name">
                  {{ $pack->name }}
                  </div>
                  <div class="pack-price">
                  {{ $pack->unit_price }} Taka
                  </div>
                  <div class="pack-amount">
                  <span>{{ number_format($pack->amount) }} OBD</span>
                  </div>
                  <div class="pack-amount">
                  <span>Total {{ number_format($pack->price) }} Taka</span>
                  </div>
                  <div class="pack-duration">
                    <div>Call Duration</div>
                    <div>max 0.29 minutes</div>
                  </div>
                  <div class="pack-validity">
                  Validity: <b>{{ $pack->validity }} days</b>
                  </div>
                  <div class="pack-setup">
                  Setup Charge: Free
                  </div>
                  <div class="pack-buy">
                    <!-- <a class="btn btn-md btn-flat btn-primary" href="{{ route('pack.purchase.select', $pack->id) }}">Buy</a> -->
                    <a class="btn btn-md btn-flat btn-primary" href="{{ route('pack.checkout', $pack->id) }}">Order Now</a>
                  </div>
                </div>
              </div>
              @endforeach

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