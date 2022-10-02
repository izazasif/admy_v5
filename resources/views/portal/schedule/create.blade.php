@extends('portal.layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Schedule OBD</h3>

            <div class="box-tools">
              <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                <div class="input-group-btn">
                  <a href="{{ route('pack.purchase') }}">
                    <button type="button" class="btn btn-primary btn-sm pull-right">
                      <i class="fa fa-usd" aria-hidden="true"></i> Buy Credit
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

              <form method="POST" action="{{ route('schedule.create.submit') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                    <label for="schedule_datetime">Date & Time</label>
                    <input type='text' class="form-control" id='datetimepicker1' name="schedule_datetime" value="{{ old('schedule_datetime') }}"/>
                  </div>
                  <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" name="category_id" id="category_id">
                      <option value="">-- Select Category --</option>
                      @foreach($categorys as $category)
                      <option value="{{ $category->id }}">{{ $category->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="app_id">App ID</label>
                    <input type="text" class="form-control" name="app_id" placeholder="Enter App ID" value="{{ old('app_id') }}">
                  </div>
                  <div class="form-group">
                    <label for="app_name">App Name</label>
                    <input type="text" class="form-control" name="app_name" placeholder="Enter App Name" value="{{ old('app_name') }}">
                  </div>
                  <div class="form-group">
                    <label for="ussd_code">USSD Code (format should be *213*XXX#)</label>
                    <input type="text" class="form-control" name="ussd_code" placeholder="Enter USSD Code" value="{{ old('ussd_code') }}">
                  </div>
                  <!-- <div class="form-group">
                    <label for="obd_amount">OBD Amount</label>
                    <input type="number" class="form-control" name="obd_amount" placeholder="Enter OBD Amount" value="{{ old('obd_amount') }}">
                  </div> -->
                  <div class="form-group">
                    <label for="obd_amount">OBD Amount</label>
                    <select class="form-control" name="obd_amount" id="obd_amount">
                      <option value="">-- Select OBD Amount --</option>
                      <option value="50000">50000</option>
                      <option value="100000">100000</option>
                      <option value="150000">150000</option>
                      <option value="200000">200000</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="audio_clip_id">OBD Clip</label>
                    <div id="clip_msg">[ Select category first to view clips ]</div>
                    <div id="no_clip_msg" style="display:none;">[ No clip found for this category ]</div>
                    @foreach($audio_clips as $audio_clip)
                    <div class="radio audio_clip cat{{ $audio_clip->category_id }}" style="display:none; margin-top: 10px;">
                      <label>
                        <input type="radio" name="audio_clip_id" value="{{ $audio_clip->id }}">
                        {{ $audio_clip->title }}
                      </label>
                      <audio controls="" style="width: 100%" controlsList="nodownload">
                        <source src="{{ asset($audio_clip->clip_path) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                      </audio>
                    </div>
                    @endforeach        
                  </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>

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