@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Schedule Web API</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="{{ route('web.api.purchase') }}">
                                            <button type="button" class="btn btn-primary btn-sm pull-right">
                                                <i class="fa fa-usd" aria-hidden="true"></i> Buy Web API
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <p>Web Promotion Request Details</p>
                        </div>
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

                                <form method="POST" action="{{ route('web.api.schedule.create.submit') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="schedule_datetime">Date & Time</label>
                                            <input type='text' class="form-control" id='datetimepicker1' name="schedule_datetime" value="{{ old('schedule_datetime') }}"/>
                                        </div>
                                        <label>Developer Information</label>
                                        <div class="form-group">
                                            <input type='text' class="form-control" id='dev_name' name="dev_name" value="{{ old('dev_name') }}" placeholder="Developer Name"/>
                                        </div>
                                        <div class="form-group">
                                            <input type='text' class="form-control" id='dev_email' name="dev_email" value="{{ old('dev_email') }}" placeholder="Developer Email"/>
                                        </div>
                                        <div class="form-group">
                                            <input type='text' class="form-control" id='dev_number' name="dev_number" value="{{ old('dev_number') }}" placeholder="Developer Mobile Number"/>
                                        </div>
                                        <label>APP Details</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="app_name" placeholder="Enter App Name" value="{{ old('app_name') }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="app_id" placeholder="Enter App ID" value="{{ old('app_id') }}">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="category_id" id="category_sms_id">
                                                <option value="">-- Select APP Type --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="app_type" placeholder="Enter APP Type" value="{{ old('app_type') }}">
                                        </div>
                                        <div class="form-group">
                                            Uploads <input type="file" class="form-control" name="deposit_slip" placeholder="Upload Deposit Slip">
                                        </div>
                                        <p>Contact Admin: +88018*****123</p>
                                    </div>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('extra-foot-scripts')
    <script type="text/javascript">
        $( "#category_sms_id" ).change(function() {
            var category_id = $(this).val();
            $(".sms_text").hide();
            $("#sms_msg").hide();
            $("#no_sms_msg").hide();

            if(category_id){
                var sms_nums = $(".cat"+category_id).length;

                if(sms_nums > 0){
                    $(".cat"+category_id).show();
                }else{
                    $("#no_sms_msg").show();
                }
            }else{
                $("#sms_msg").show();
            }

        });
    </script>
@endsection
