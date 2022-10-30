@extends('portal.layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
    <div class="col-sm-10 col-xs-12">
        <form class="" method="post" action="{{ route('schedule.report') }}">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body" style="">
                <div class="distable">

                  <div class="distable-row">
                  <div class="form-group distable-cell">
                      <label for="shrdaterange">Schedule Date Range</label>
                      <input style="position: inherit;" class="form-control input-sm daterangepicker" type="text" name="shrdaterange" placeholder="Choose Date Range" value="{{ session()->has('shrdaterange') ? session()->get('shrdaterange') : '' }}">
                    </div>
                    <div class="form-group distable-cell">
                      <label for="shrcategory">Category</label>
                      <select class="form-control input-sm" id="shrcategory" name="shrcategory">
                        <option value="0">Choose Category</option>
                        @foreach($categories as $category)
                          <option value="{{ $category->id }}" {{ (session()->has('shrcategory') && session()->get('shrcategory') == $category->id) ? 'selected' : '' }}>{{ $category->title }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group distable-cell">
                      <label for="shrapp_id">App ID</label>
                      <input class="form-control input-sm" type="text" name="shrapp_id" placeholder="Type App ID here.." value="{{ session()->has('shrapp_id') ? session()->get('shrapp_id') : '' }}">
                    </div>

                    <div class="form-group distable-cell">
                      <label for="shrapp_name">App Name</label>
                      <input class="form-control input-sm" type="text" name="shrapp_name" placeholder="Type App Name here.." value="{{ session()->has('shrapp_name') ? session()->get('shrapp_name') : '' }}">
                    </div>

                    <div class="form-group distable-cell">
                      <label for="shrussd_code">USSD Code</label>
                      <input class="form-control input-sm" type="text" name="shrussd_code" placeholder="Type USSD Code here.." value="{{ session()->has('shrussd_code') ? session()->get('shrussd_code') : '' }}">
                    </div>

                    <div class="distable-cell search-btns" style="padding-left: 20px;">
                      <button type="submit" class="btn btn-sm btn-flat btn-primary" name="search">Search</button>
                    </div>
                    <div class="distable-cell search-btns">
                      <a class="btn btn-sm btn-flat btn-warning" href="{{ route('schedule.report.reset') }}">Reset</a>
                    </div>
                  </div>

                </div>
                <input type="hidden" value="{{csrf_token()}}" name="_token" />
            </div>

          </div>
        </form>
      </div>
      <div class="col-sm-10 col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Schedule Report</h3>
          </div>

          @if (session('message')) 
          <div class="alert alert-success text-center">
            <ul style="list-style-type: none">
              <li>
                <a  class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('message') }}
              </li>
            </ul>
          </div>    
          @endif

          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-bordered table-hover" style="margin-top:20px; margin-bottom:30px">
              <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Schedule Date</th>
                <th class="text-center">Schedule Time</th>
                <th class="text-center">Actual Delivery Time</th>
                <th class="text-center">Category</th>
                <th class="text-center">App ID</th>
                <th class="text-center">App Name</th>
                <th class="text-center">USSD Code</th>
                <th class="text-center">OBD Clip</th>
                <th class="text-center">OBD Amount</th>
                <th class="text-center" style="background-color: #d6d640;">Sent Amount</th>
                <th class="text-center" style="background-color: #49a0d2;">Success</th>
                <th class="text-center" style="background-color: #e86969;">Not Responded</th>
                <th class="text-center" style="background-color: #6cb926;">Subscribed</th>
              </tr>
              @php $sl = ($report_data->currentpage()-1)* $report_data->perpage()+1 @endphp
              @foreach( $report_data as $report ) 
              <tr>
                <td class="text-center">{{ $sl++ }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($report->schedule_time)) }}</td>
                <td class="text-center">{{ date('h:i A', strtotime($report->schedule_time)) }}</td>
                <td class="text-center">{{ date('d-m-Y h:i A', strtotime($report->actual_delivery_time)) }}</td>
                <td class="text-center">{{ $report->category_name }}</td>
                <td class="text-center">{{ $report->app_id }}</td>
                <td class="text-center">{{ $report->app_name }}</td>
                <td class="text-center">{{ $report->ussd_code }}</td>
                <td class="text-center">{{ $report->clip_name }}</td>
                <td class="text-center">{{ number_format($report->obd_amount) }}</td>
                <td class="text-center" style="background-color: #d6d640;">{{ number_format($report->sent_amount) }}</td>
                <td class="text-center" style="background-color: #49a0d2;">{{ number_format($report->success_amount) }}</td>
                <td class="text-center" style="background-color: #e86969;">{{ number_format($report->failed_amount) }}</td>
                <td class="text-center" style="background-color: #6cb926;">{{ number_format($report->subscribed_amount) }}</td>
              </tr>
              @endforeach
            </table>
            <div class="text-center">
              {{ $report_data->links() }}
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