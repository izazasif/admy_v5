@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Schedule SMS (Pro App Only)</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="{{ route('sms.purchase') }}">
                                            <button type="button" class="btn btn-primary btn-sm pull-right">
                                                <i class="fa fa-usd" aria-hidden="true"></i> Buy SMS Credit
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

                                <form method="POST" action="{{ route('sms.schedule.create.submit') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="schedule_datetime">Date & Time</label>
                                            <input type='text' class="form-control" id='datetimepicker1' name="schedule_datetime" value="{{ old('schedule_datetime') }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">Category</label>
                                            <select class="form-control" name="category_id" id="category_sms_id">
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="app_id">App ID (Pro App Only)</label>
                                            <input type="text" class="form-control" name="app_id" placeholder="Enter App ID" value="{{ old('app_id') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="app_name">App Name (Pro App Only)</label>
                                            <input type="text" class="form-control" name="app_name" placeholder="Enter App Name" value="{{ old('app_name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="ussd_code">USSD Code (format should be *213*XXX#)</label>
                                            <input type="text" class="form-control" name="ussd_code" placeholder="Enter USSD Code" value="{{ old('ussd_code') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="sms_amount">SMS Amount</label>
                                            <select class="form-control" name="sms_amount" id="sms_amount">
                                                <option value="">-- Select sms Amount --</option>
                                                <!-- <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="200">200</option> -->
                                                <option value="1000">{{ number_format(1000) }}</option>
                                                <option value="1200">{{ number_format(1200) }}</option>
                                                <option value="2500">{{ number_format(2500) }}</option>
                                                <option value="5000">{{ number_format(5000) }}</option>
                                                <option value="10000">{{ number_format(10000) }}</option>
                                                <option value="15000">{{ number_format(15000) }}</option>
                                                <option value="20000">{{ number_format(20000) }}</option>
                                                <option value="50000">{{ number_format(50000) }}</option>
                                                <option value="100000">{{ number_format(100000) }}</option>
                                                <option value="150000">{{ number_format(150000) }}</option>
                                                <option value="200000">{{ number_format(200000) }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="sms_text_id">SMS Text</label>
                                            <div id="sms_msg">[ Select category first to view SMS Texts  ]</div>
                                            <div id="no_sms_msg" style="display:none;">[ No SMS text found for this category ]</div>
                                            @foreach($sms_texts as $text)
                                                <div class="radio sms_text cat{{ $text->category_id }}" style="display:none; margin-top: 10px;">
                                                    <label>
                                                        <input type="radio" name="sms_text_id" value="{{ $text->id }}">
                                                        {{ $text->text }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <label for="up_to_date">Content Up to Date</label>
                                            <input type="checkbox" id="up_to_date" name="is_content_up_to_date" class="form-check-input" {{ (old('is_content_up_to_date')=='1') ? 'checked' : '' }} value="1"> Is Content Up to Date?
                                        </div>
                                        <div class="form-group">
                                            <label for="uat_done">APP UAT Done</label>
                                            <input type="checkbox" id="uat_done" name="is_app_uat_done" class="form-check-input" {{ (old('is_app_uat_done')=='1') ? 'checked' : '' }} value="1"> Is App UAT Done?
                                        </div>
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <textarea name="remark" id="remark" class="form-control">
                                                {{ old('remark') }}
                                            </textarea>
                                        </div>
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
