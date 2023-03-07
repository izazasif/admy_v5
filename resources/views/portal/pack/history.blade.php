@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-10 col-xs-12">
                    <form class="" method="post" action="{{ route('pack.history') }}">
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
                                            <label for="shpdaterange">Date Range</label>
                                            <input style="position: inherit;" class="form-control input-sm daterangepicker"
                                                type="text" name="shpdaterange" placeholder="Choose Date Range"
                                                value="{{ session()->has('shpdaterange') ? session()->get('shpdaterange') : '' }}">
                                        </div>
                                        <div class="form-group distable-cell">
                                            <label for="shpack">Pack</label>
                                            <select class="form-control input-sm" id="shpack" name="shpack">
                                                <option value="0">Choose Pack</option>
                                                @foreach ($packs as $pack)
                                                    <option value="{{ $pack->id }}"
                                                        {{ session()->has('shpack') && session()->get('shpack') == $pack->id ? 'selected' : '' }}>
                                                        {{ $pack->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="distable-cell search-btns" style="padding-left: 20px;">
                                            <button type="submit" class="btn btn-sm btn-flat btn-primary"
                                                name="search">Search</button>
                                        </div>
                                        <div class="distable-cell search-btns">
                                            <a class="btn btn-sm btn-flat btn-warning"
                                                href="{{ route('pack.history.reset') }}">Reset</a>
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
                            <h3 class="box-title">Buy Pack History</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="{{ route('pack.purchase') }}">
                                            <button type="button" class="btn btn-primary btn-sm pull-right">
                                                <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;Buy Packs
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
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
                                    <th class="text-center">Buy Date</th>
                                    <th class="text-center">Pack Name</th>
                                    <th class="text-center">Credit</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Validity</th>
                                    <th class="text-center">Valid Till</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Invoice</th>
                                </tr>
                                @php $sl = ($user_packs->currentpage()-1)* $user_packs->perpage()+1 @endphp
                                @foreach ($user_packs as $pack)
                                    <tr>
                                        <td class="text-center">{{ $sl++ }}</td>
                                        <td class="text-center">{{ date('d-m-Y h:i A', strtotime($pack->created_at)) }}
                                        </td>
                                        <td class="text-center">{{ $pack->getPack->name }}</td>
                                        <td class="text-center">{{ number_format($pack->getPack->amount) }}</td>
                                        <td class="text-center">{{ $pack->getPack->price }} Taka</td>
                                        <td class="text-center">{{ $pack->getPack->validity }} Days</td>
                                        <td class="text-center">{{ date('d-m-Y h:i A', strtotime($pack->valid_till)) }}
                                        </td>
                                        <td class="text-center">
                                            @if ($pack->status == 0)
                                                <span style="color:blue"><b><i class="fa fa-clock-o"
                                                            aria-hidden="true"></i>&nbsp;Pending</b></span>
                                            @elseif ($pack->valid_till >= date('Y-m-d H:i:s'))
                                                <span style="color:green"><b><i class="fa fa-check"
                                                            aria-hidden="true"></i>&nbsp;Active</b></span>
                                            @else
                                                <span style="color:red"><b><i class="fa fa-times"
                                                            aria-hidden="true"></i>&nbsp;Expired</b></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('obd.invoice', $pack->id) }}">
                                                <i class="fa fa-file-pdf-o" style="font-size:24px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="text-center">
                                {{ $user_packs->links() }}
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
