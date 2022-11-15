@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content">
            <div class="row">
                <div class="col-sm-10 col-xs-12">
                    <form class="" method="get" action="{{ route('sms.schedule.list') }}">
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
                                            <label for="dateRange">Schedule Date Range</label>
                                            <input style="position: inherit;" class="form-control input-sm daterangepicker"
                                                defaultValue=""
                                                value="{{ session()->has('dateRangeStat') && session()->get('dateRangeStat') ? session()->get('dateRangeStat') : '' }}"
                                                type="text" name="dateRange" placeholder="Choose Date Range">
                                        </div>

                                        <div class="distable-cell search-btns" style="padding-left: 20px;">
                                            <button type="submit" class="btn btn-sm btn-flat btn-primary"
                                                name="search">Search</button>
                                        </div>
                                        <div class="distable-cell search-btns">
                                            <a class="btn btn-sm btn-flat btn-warning"
                                                href="{{ route('sms.schedule.list') }}">Reset</a>
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
                            <h3 class="box-title">Schedule List</h3>
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
                            <table class="table table-bordered table-hover"
                                style="margin-top:20px; margin-bottom:30px;width:100%">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Schedule Date</th>
                                    <th class="text-center">Schedule Time</th>
                                    <th class="text-center">App ID</th>
                                    <th class="text-center">App Name</th>
                                    <th class="text-center">USSD Code</th>
                                    <th class="text-center">SMS Amount</th>
                                    <th style="width:20%">SMS Text</th>
                                    <th class="text-center">Remark</th>
                                    <th class="text-center">Content up to date?</th>
                                    <th class="text-center">App UAT Done?</th>
                                    <th class="text-center">Creation Time</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                    <th class="text-center">Stat</th>
                                </tr>
                                @php $sl=1 @endphp
                                @php $sl = ($all_schedule_list->currentpage()-1)* $all_schedule_list->perpage()+1 @endphp
                                @foreach ($all_schedule_list as $schedule)
                                    <tr>
                                        <td class="text-center">{{ $sl++ }}</td>
                                        <td class="text-center">{{ $schedule->getUser->username }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($schedule->schedule_time)) }}
                                        </td>
                                        <td class="text-center">{{ date('h:i A', strtotime($schedule->schedule_time)) }}
                                        </td>
                                        <td class="text-center">{{ $schedule->app_id }}</td>
                                        <td class="text-center">{{ $schedule->app_name }}</td>
                                        <td class="text-center">{{ $schedule->ussd_code }}</td>
                                        <td class="text-center">{{ number_format($schedule->sms_amount) }}</td>
                                        <td class="text-center">{{ $schedule->text->text }}</td>
                                        <td class="text-center">{{ $schedule->remark }}</td>
                                        <td class="text-center">{{ $schedule->is_content_up_to_date ? 'yes' : 'no' }}
                                        </td>
                                        <td class="text-center">{{ $schedule->is_app_uat_done ? 'yes' : 'no' }}</td>
                                        <td class="text-center">{{ date('d-m-Y h:i A', strtotime($schedule->created_at)) }}
                                        </td>
                                        <td class="text-center">
                                            @if ($schedule->status)
                                                <span style="color:green"><b><i class="fa fa-check"
                                                            aria-hidden="true"></i>&nbsp;Delivered</b></span>
                                            @else
                                                <span style="color:red"><b><i class="fa fa-clock-o"
                                                            aria-hidden="true"></i>&nbsp;Pending</b></span>
                                            @endif
                                        </td>
                                        @if (!$schedule->status)
                                            <td class="text-center">
                                                <a href="{{ route('sms.campaign.start', $schedule->id) }}"><i
                                                        class="fa fa-rocket" aria-hidden="true"></i> Deliver</a>
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            @if ($schedule->status)
                                                <a href="{{ route('sms.campaign.information', $schedule->id) }}"><i
                                                        class="fa fa-rocket" aria-hidden="true"></i>Check Information</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($schedule->status)
                                                <a
                                                    href="{{ route('sms.campaing.stat2', ['user' => $schedule->getUser->email, 'daterange' => session()->get('dateRangeStat')]) }}"><i
                                                        class="fa fa-line-chart" aria-hidden="true"></i>Check Stat</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="text-center">
                                {{ $all_schedule_list->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
