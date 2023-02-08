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
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body" style="">
                                <div class="distable">

                                    <div class="distable-row">
                                        <div class="form-group distable-cell">
                                            <label for="shdaterange">Date Range</label>
                                            <input style="position: inherit;" class="form-control input-sm daterangepicker"
                                                type="text" name="shdaterange" placeholder="Choose Date Range"
                                                value="{{ session()->has('search_date_schedule') ? session()->get('search_date_schedule') : '' }}">
                                        </div>
                                        <div class="distable-cell search-btns" style="padding-left: 20px;">
                                            <button type="submit" class="btn btn-sm btn-flat btn-primary"
                                                name="search">Search</button>
                                        </div>
                                        <div class="distable-cell search-btns">
                                            <a class="btn btn-sm btn-flat btn-warning"
                                                href="{{ route('schedule_report.reset') }}">Reset</a>
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
                            <h3 class="box-title">Daily Schedule Report</h3>
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
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">App Name</th>
                                    <th class="text-center">App Id </th>
                                    <th class="text-center">Schedule Amount</th>
                                </tr>
                                @php $sl = 1; @endphp
                                @foreach ($schedule_total_obd1 as $schedule)
                                    <tr>
                                      <td class="text-center">{{ $sl++ }}</td>
                                      <td class="text-center">{{ date('d-m-Y', strtotime($schedule->date)) }}</td>
                                      <td class="text-center">{{ $schedule->type }}</td>
                                      <td class="text-center">{{ $schedule->app_name }}</td>     
                                      <td class="text-center">{{ $schedule->app_id }}</td>
                                      <td class="text-center">{{ $schedule->total }}</td>
                                   </tr>  
                                @endforeach
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center" >{{$total_1}}</th>
                                </tfoot>
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
