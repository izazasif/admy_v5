@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Web API Schedule History</h3>
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
                            <table class="table table-bordered table-hover" style="margin-top:20px; margin-bottom:30px;width:100%">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">User</th>
{{--                                    <th class="text-center">Category</th>--}}
                                    <th class="text-center">Schedule Date</th>
                                    <th class="text-center">Schedule Time</th>
                                    <th class="text-center">App ID</th>
                                    <th class="text-center">App Name</th>
                                    <th class="text-center">APP Type</th>
                                    <th class="text-center">Developer Name</th>
                                    <th  class="text-center">Developer Email</th>
                                    <th  class="text-center">Developer Mobile</th>
                                    <th  class="text-center">Deposit Slip</th>
                                    <th class="text-center">Creation Time</th>
                                    <th class="text-center">Status</th>
                                </tr>
                                @php $sl=1 @endphp
                                @php $sl = ($all_schedule_list->currentpage()-1)* $all_schedule_list->perpage()+1 @endphp
                                @foreach( $all_schedule_list as $schedule )
                                    <tr>
                                        <td class="text-center">{{ $sl++ }}</td>
                                        <td class="text-center">{{ $schedule->getUser->username }}</td>
{{--                                        <td class="text-center">{{ $schedule->cateogory->title }}</td>--}}
                                        <td class="text-center">{{ date('d-m-Y', strtotime($schedule->schedule_time)) }}</td>
                                        <td class="text-center">{{ date('h:i A', strtotime($schedule->schedule_time)) }}</td>
                                        <td class="text-center">{{ $schedule->app_id }}</td>
                                        <td class="text-center">{{ $schedule->app_name }}</td>
                                        <td class="text-center">{{ $schedule->app_type }}</td>
                                        <td class="text-center">{{ $schedule->dev_name }}</td>
                                        <td class="text-center">{{ $schedule->dev_email }}</td>
                                        <td class="text-center">{{ $schedule->dev_number }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('slips/'.$schedule->deposit_slip) }}" height="80px">
                                        </td>
                                        <td class="text-center">{{ date('d-m-Y h:i A', strtotime($schedule->created_at)) }}</td>
                                        <td class="text-center">
                                            @if($schedule->status)
                                                <span style="color:green"><b><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Delivered</b></span>
                                            @else
                                                <span style="color:red"><b><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Pending</b></span>
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
