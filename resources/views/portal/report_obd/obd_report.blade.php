@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-10 col-xs-12">
                    <form class="" method="post" action="{{ route('obd.report') }}">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Search</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body" style="">
                                <div class="distable">

                                    <div class="distable-row">
                                        <div class="form-group distable-cell">
                                            <label for="shdaterange">Schedule Date Range</label>
                                            <input style="position: inherit;" class="form-control input-sm daterangepicker"
                                                type="text" name="shdaterange" placeholder="Choose Date Range"
                                                value="{{ session()->has('shdaterange') ? session()->get('shdaterange') : '' }}">
                                        </div>
                                        <div class="distable-cell search-btns" style="padding-left: 20px;">
                                            <button type="submit" class="btn btn-sm btn-flat btn-primary"
                                                name="search">Search</button>
                                        </div>
                                        <div class="distable-cell search-btns">
                                            <a class="btn btn-sm btn-flat btn-warning"
                                                href="{{ route('schedule.list.reset') }}">Reset</a>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">OBD Report </h3>
                        </div>

                        @if (session('message'))
                            <div class="alert alert-success text-center">
                                <ul style="list-style-type: none">
                                    <li>
                                        <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
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
                                    <th class="text-center">User</th>
                                    <th class="text-center">Creation Time </th>
                                    <th class="text-center">Schedule Time</th>
                                    <th class="text-center">Category </th>
                                    <th class="text-center">App Id</th>
                                    <th class="text-center">App Name </th>
                                    <th class="text-center">Obd Amount</th>
                                    <th class="text-center">OBD Clip </th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Delivery time </th>
                                    <th class="text-center">Send Amount </th>
                                    <th class="text-center">Success Amount </th>
                                    <th class="text-center">Failed Amount </th>
                                    <th class="text-center">Subscribed Amount  </th>
                                </tr>
                                
                                @php $sl = 1; @endphp
                                @foreach ($all_schedule_list as $schedule)
                                    <tr>
                                      <td class="text-center">{{ $sl++ }}</td>
                                      <td class="text-center">{{$schedule->getUser->email }}</td>
                                      <td class="text-center"> {{ date('d-m-Y h:i A', strtotime($schedule->created_at)) }}</td>
                                      <td class="text-center">{{ date('h:i A', strtotime($schedule->schedule_time)) }}</td>
                                      <td class="text-center">{{$schedule->category_name }}</td>     
                                      <td class="text-center">{{$schedule->app_id}}</td>
                                      <td class="text-center">{{$schedule->app_name}}</td>
                                      <td class="text-center">{{number_format($schedule->obd_amount)}}</td>
                                      <td class="text-center">{{$schedule->clip_name }}</td>
                                      <td class="text-center">
                                           @if ($schedule->status == -1)
                                                <span style="color:red"><b><i class="fa fa-times"
                                                            aria-hidden="true"></i>&nbsp;Rejected</b></span>
                                            @elseif ($schedule->status == 1)
                                                <span style="color:green"><b><i class="fa fa-check"
                                                            aria-hidden="true"></i>&nbsp;Delivered</b></span>
                                            @else
                                                <span style="color:blue"><b><i class="fa fa-clock-o"
                                                            aria-hidden="true"></i>&nbsp;Pending</b></span>
                                            @endif
                                      </td>
                                      <td class="text-center">{{$schedule->actual_delivery_time}}</td>     
                                      <td class="text-center">{{$schedule->sent_amount}}</td>
                                      <td class="text-center">{{$schedule->success_amount}}</td>
                                      <td class="text-center">{{$schedule->failed_amount}}</td>     
                                      <td class="text-center">{{$schedule->subscribed_amount}}</td>
                                   </tr>  
                                @endforeach

                              
                               
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
  
   
@endsection
