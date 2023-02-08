@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-10 col-xs-12">
                    <form class="" method="post" action="{{ route('schedule.list') }}">
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
                                        <!-- <div class="form-group distable-cell">
                                                                                                  <label for="shfromdate">From Date</label>
                                                                                                  <input class="form-control input-sm datepicker" type="text" name="shfromdate" placeholder="From date" value="{{ session()->has('shfromdate') ? session()->get('shfromdate') : '' }}">
                                                                                                </div>

                                                                                                <div class="form-group distable-cell">
                                                                                                  <label for="shtodate">To Date</label>
                                                                                                  <input class="form-control input-sm datepicker" type="text" name="shtodate" placeholder="To date" value="{{ session()->has('shtodate') ? session()->get('shtodate') : '' }}">
                                                                                                </div> -->
                                        <div class="form-group distable-cell">
                                            <label for="shcategory">Category</label>
                                            <select class="form-control input-sm" id="shcategory" name="shcategory">
                                                <option value="0">Choose Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ session()->has('shcategory') && session()->get('shcategory') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group distable-cell">
                                            <label for="app_id">App ID</label>
                                            <input class="form-control input-sm" type="text" name="app_id"
                                                placeholder="Type App ID here.."
                                                value="{{ session()->has('app_id') ? session()->get('app_id') : '' }}">
                                        </div>

                                        <div class="form-group distable-cell">
                                            <label for="app_name">App Name</label>
                                            <input class="form-control input-sm" type="text" name="app_name"
                                                placeholder="Type App Name here.."
                                                value="{{ session()->has('app_name') ? session()->get('app_name') : '' }}">
                                        </div>

                                        <div class="form-group distable-cell">
                                            <label for="ussd_code">USSD Code</label>
                                            <input class="form-control input-sm" type="text" name="ussd_code"
                                                placeholder="Type USSD Code here.."
                                                value="{{ session()->has('ussd_code') ? session()->get('ussd_code') : '' }}">
                                        </div>

                                        <div class="form-group distable-cell">
                                            <label for="shstatus">Status</label>
                                            <select class="form-control input-sm" id="shstatus" name="shstatus">
                                                <option value="0">Choose Status</option>
                                                <option value="active"
                                                    {{ session()->has('shstatus') && session()->get('shstatus') == 'active' ? 'selected' : '' }}>
                                                    Delivered</option>
                                                <option value="inactive"
                                                    {{ session()->has('shstatus') && session()->get('shstatus') == 'inactive' ? 'selected' : '' }}>
                                                    Pending</option>
                                            </select>
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
                            <table class="table table-bordered table-hover" style="margin-top:20px; margin-bottom:30px">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Schedule Date</th>
                                    <th class="text-center">Schedule Time</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">App ID</th>
                                    <th class="text-center">App Name</th>
                                    <th class="text-center">USSD Code</th>
                                    <th class="text-center">OBD Amount</th>
                                    <th class="text-center">OBD Clip</th>
                                    <th class="text-center">Creation Time</th>
                                    <th class="text-center">Status</th>
                                    @if (session()->get('permission') != 'obd_viewer')
                                        <th class="text-center">Action</th>
                                    @endif
                                </tr>
                                @php $sl = ($all_schedule_list->currentpage()-1)* $all_schedule_list->perpage()+1 @endphp
                                @foreach ($all_schedule_list as $schedule)
                                    <tr>
                                        <td class="text-center">{{ $sl++ }}</td>
                                        <td class="text-center">{{ $schedule->getUser->email }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($schedule->schedule_time)) }}
                                        </td>
                                        <td class="text-center">{{ date('h:i A', strtotime($schedule->schedule_time)) }}
                                        </td>
                                        <td class="text-center">{{ $schedule->getCategory->title }}</td>
                                        <td class="text-center">{{ $schedule->app_id }}</td>
                                        <td class="text-center">{{ $schedule->app_name }}</td>
                                        <td class="text-center">{{ $schedule->ussd_code }}</td>
                                        <td class="text-center">{{ number_format($schedule->obd_amount) }}</td>
                                        <td class="text-center">{{ $schedule->getAudioClip->title }}</td>
                                        <td class="text-center">
                                            {{ date('d-m-Y h:i A', strtotime($schedule->created_at)) }}</td>
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
                                        @if (!$schedule->status)
                                            <!-- <td class="text-center">
                                                                                              <a href="{{ route('schedule.list.update', $schedule->id) }}">
                                                                                                <button type="button" class="btn btn-primary btn-xs">
                                                                                                  <i class="fa fa-rocket" aria-hidden="true"></i> Deliver
                                                                                                </button>
                                                                                              </a>
                                                                                            </td> -->
                                            @if (session()->get('permission') != 'obd_viewer')
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary btn-xs deliver_btn"
                                                        data-toggle="modal" data-target="#exampleModal"
                                                        data-id="{{ $schedule->id }}">
                                                        <i class="fa fa-rocket" aria-hidden="true"></i> Deliver
                                                    </button>
                                                    <a href="{{ route('obdSreject', $schedule->id) }}">
                                                        <button type="button" class="btn btn-danger btn-xs deliver_btn">
                                                            <i class="fa fa-times" aria-hidden="true"></i> Reject
                                                        </button>
                                                    </a>
                                                </td>
                                            @endif

                                            @elseif ($schedule->status == 1)
                                              <td class="text-center">
                                              <a class="btn btn-primary btn-xs deliver_btn" href="" data-toggle="modal"  data-target="#exampleModal_view{{ $schedule->id   }}"> <i class="fa fa-eye" aria-hidden="true"></i> view</a>
                                              </td>
                                        @endif
                                    </tr>
                                                                                                            <!-- /.content-wrapper -->
                                                                            <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal_view{{$schedule->id}}">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header text-center">
                                                                                            <h5 class="modal-title" style="font-size: 24px; font-weight:bold;">Report Data</h5>
                                                                                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                                                                            </button> -->
                                                                                        </div>
                                                                                        
                                                                                            <div class="modal-body">
                                                                                            @php                          
                                                                                            $data =  \App\Models\Report::where(['schedule_id' => $schedule->id])->first();
                                                                                            $data_actual_time = \App\Models\Schedule::where(['id' => $schedule->id])->pluck('actual_delivery_time')->first(); 
                                                                                         
                                                                                            @endphp
                                                                                                <input type="hidden" name="schedule_id" id="schedule_id">
                                                                                                <div class="box-body">
                                                                                                    <div class="form-group">
                                                                                                        <label for="actual_delivery_time">Actual Delivery Time</label>
                                                                                                       
                                                                                                        <h4 class="box-title"> <span> {{ date('d-m-Y h:i A', strtotime($data_actual_time)) }} </span> </h4>
                                                                                                    </div>
                                                                                                  
                                                                                                    <div class="form-group">
                                                                                                        <label for="sent_amount">Send Amount</label>
                                                                                                        <!-- <input type="number" class="form-control" name="sent_amount"
                                                                                                             value="{{ $data->sent_amount ?? 'None' }}" disabled> -->
                                                                                                             <h4 class="box-title"> <span>{{ $data->sent_amount ?? 'None' }} </span> </h4>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <label for="sent_amount">Success Amount</label>
                                                                                                 
                                                                                                             <h4 class="box-title"> <span>{{ $data->success_amount ?? 'None' }} </span> </h4>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <label for="sent_amount">Failed Amount</label>
                                                                                                        
                                                                                                             <h4 class="box-title"> <span>{{$data->failed_amount ?? 'None' }} </span> </h4>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <label for="sent_amount">Subscribed Amount</label>
                                                                                                        
                                                                                                             <h4 class="box-title"> <span>{{$data->subscribed_amount ?? 'None'  }} </span> </h4>
                                                                                                    </div>
                                                                                                    
                                                                                                    
                                                                                                </div>
                                                                                                <!-- /.box-body -->

                                                                                                <!-- <div class="box-footer">
                                                                                                                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                                                                                                                                </div> -->
                                                                                            </div>
                                                                                            <!-- <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                                                            </div> -->
                                                                                      
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                @endforeach
                            </table>
                            <div class="text-center">
                                {{ $all_schedule_list->links() }}
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
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" style="font-size: 24px; font-weight:bold;">Report Data</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                      <span aria-hidden="true">&times;</span>
                                                                                    </button> -->
                </div>
                <form method="POST" action="{{ route('schedule.list.update') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="schedule_id" id="schedule_id">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="actual_delivery_time">Actual Delivery Time</label>
                                <input type="text" id='datetimepicker1' class="form-control"
                                    name="actual_delivery_time" placeholder="Enter Actual Delivery Time" value=""
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="sent_amount">Sent Amount</label>
                                <input type="number" class="form-control" name="sent_amount"
                                    placeholder="Enter Sent Amount" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="success_amount">Success Amount</label>
                                <input type="number" class="form-control" name="success_amount"
                                    placeholder="Enter Success Amount" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="failed_amount">Failed Amount</label>
                                <input type="number" class="form-control" name="failed_amount"
                                    placeholder="Enter Failed Amount" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="subscribed_amount">Subscribed Amount</label>
                                <input type="number" class="form-control" name="subscribed_amount"
                                    placeholder="Enter Subscribed Amount" value="" required>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <!-- <div class="box-footer">
                                                                                          <button type="submit" class="btn btn-primary">Submit</button>
                                                                                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
@endsection
