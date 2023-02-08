@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-10 col-xs-12">
                    <form class="" method="post" action="{{ route('report.user') }}">
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
                            <h3 class="box-title">User Registration Count </h3>
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
                                    <th class="text-center">Reg Count </th>
                                </tr>
                                @php $sl = 0; @endphp
                                @foreach ($user_total as $user)
                                    <tr>
                                      <td class="text-center">{{ $sl++ }}</td>
                                      <td class="text-center">{{ $user->date }}</td>
                                      <td class="text-center">{{ $user->total }}</td>  
                                   </tr>  
                                @endforeach

                                <tfoot>
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
