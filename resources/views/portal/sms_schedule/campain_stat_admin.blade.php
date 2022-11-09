@extends('portal.layouts.master')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-10 col-xs-12">
                    <form class="" method="post" action="{{ route('sms.campaing.stat') }}">
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
                                                value="{{ session()->has('dateRangeStat') && session()->get('dateRangeStat') ? session()->get('dateRangeStat') : '' }}"
                                                type="text" name="dateRange" placeholder="Choose Date Range">
                                        </div>

                                        <div class="form-group distable-cell">
                                            <label for="clientId">User</label>
                                            <select class="form-control input-sm" id="clientId" name="clientId" required>
                                                <option value="">---Choose User---</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->email }}"
                                                        {{ session()->has('clientId') && session()->get('clientId') == $user->email ? 'selected' : '' }}>
                                                        {{ $user->username }}-{{ $user->email }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="distable-cell search-btns" style="padding-left: 20px;">
                                            <button type="submit" class="btn btn-sm btn-flat btn-primary"
                                                name="search">Search</button>
                                        </div>
                                        <div class="distable-cell search-btns">
                                            <a class="btn btn-sm btn-flat btn-warning"
                                                href="{{ route('sms.campaing.list.admin') }}">Reset</a>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-sm-10 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Campaing Stat</h3>
                        </div>

                        @if (session('message'))
                            <div class="alert alert-danger text-center">
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
                                    <th class="text-center">Sent</th>
                                    <th class="text-center">Delivered</th>
                                    <th class="text-center">Conversions</th>
                                    <th class="text-center">Parked</th>
                                    <th class="text-center">Date</th>

                                </tr>
                                @php $sl=1 @endphp
                                @if (!$data)
                                    <tr>
                                        <td colspan="6" class="text-center">Please, use search to see the stat.</td>
                                    </tr>
                                @else
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center">{{ $sl++ }}</td>
                                            <td class="text-center">{{ $item->sent }}</td>
                                            <td class="text-center">{{ $item->delivered }}</td>
                                            <td class="text-center">{{ $item->conversions }}</td>
                                            <td class="text-center">{{ $item->parked }}</td>
                                            <td class="text-center">{{ $item->date }}</td>
                                        </tr>
                                    @endforeach
                                @endif
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
