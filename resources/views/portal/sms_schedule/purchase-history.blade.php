@extends('portal.layouts.master')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Push SMS Purchase History</h3>
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
                                    <th class="text-center">Package ID</th>
                                    <th class="text-center">Chanel</th>
                                    <th class="text-center">SMS Credits</th>
                                    <th class="text-center">Payment Status</th>
                                    <th class="text-center">Validity</th>
                                    <th class="text-center">Creation Time</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Invoice</th>
                                </tr>
                                @php $sl=1 @endphp
                                @php $sl = ($lists->currentpage()-1)* $lists->perpage()+1 @endphp
                                @foreach ($lists as $list)
                                    <tr>
                                        <td class="text-center">{{ $sl++ }}</td>
                                        <td class="text-center">
                                            {{ $list->package_id ? $list->package_id : 'Bank Transfer' }}
                                        </td>
                                        <td class="text-center">{{ $list->channel }}</td>
                                        <td class="text-center">{{ number_format($list->amount) }}</td>
                                        <td class="text-center">{{ $list->payment_status }}</td>
                                        <td class="text-center">{{ date('d-m-Y h:i A', strtotime($list->valid_till)) }}</td>
                                        <td class="text-center">{{ date('d-m-Y h:i A', strtotime($list->created_at)) }}</td>
                                        <td class="text-center">
                                            @if ($list->payment_status == 'Pending')
                                                <span style="color:blue"><b><i class="fa fa-clock-o"
                                                            aria-hidden="true"></i>&nbsp Pending</b></span>
                                            @elseif ($list->is_active == 1 && strtotime($list->valid_till) >= strtotime('now'))
                                                <span style="color:green"><b><i class="fa fa-check"
                                                            aria-hidden="true"></i>&nbsp;Active</b></span>
                                            @else
                                                <span style="color:red"><b><i class="fa fa-times"
                                                            aria-hidden="true"></i>&nbsp Expired</b></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('pushsms.invoice', $list->id) }}">
                                                <i class="fa fa-file-pdf-o" style="font-size:24px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="text-center">
                                {{ $lists->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
