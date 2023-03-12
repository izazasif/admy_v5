@extends('portal.layouts.master')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">OBD Pending Bank Payment</h3>
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
                                    <th class="text-center">Pay SLip</th>
                                    <th class="text-center">OBD Credits</th>
                                    <th class="text-center">Price(Included vat&charge)</th>
                                    <th class="text-center">Validity</th>
                                    <th class="text-center">Creation Time</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                @php $sl=1 @endphp
                                @php $sl = ($lists->currentpage()-1)* $lists->perpage()+1 @endphp
                                @if (sizeof($lists) == 0)
                                    <td class="text-center" colspan="8"> No data</td>
                                @else
                                    @foreach ($lists as $list)
                                        <tr>
                                            <td class="text-center">{{ $sl++ }}</td>

                                            <td class="text-center">
                                                <a class=".btn.btn-app" target="_blank"
                                                    href="{{ url('assets/payslip_obd/' . $list->slip_file) }}">
                                                    <button>view pay slip</button>
                                                </a>
                                            </td>
                                            <td class="text-center">{{ number_format($list->amount) }}</td>
                                            <td class="text-center">
                                                {{ number_format($list->base_price + $list->base_price * (($list->vat + $list->gateway_charge) / 100)) }}
                                            </td>

                                            <td class="text-center">{{ date('d-m-Y h:i A', strtotime($list->valid_till)) }}
                                            </td>
                                            <td class="text-center">{{ date('d-m-Y h:i A', strtotime($list->created_at)) }}
                                            </td>
                                            <td class="text-center">
                                                @if ($list->status == 0)
                                                    <span style="color:blue"><b><i class="fa fa-clock-o"
                                                                aria-hidden="true"></i>&nbsp; Pending</b></span>
                                                @elseif ($list->status == 1 && strtotime($list->valid_till) >= strtotime('now'))
                                                    <span style="color:green"><b><i class="fa fa-check"
                                                                aria-hidden="true"></i>&nbsp;Active</b></span>
                                                @else
                                                    <span style="color:red"><b><i class="fa fa-times"
                                                                aria-hidden="true"></i>&nbsp; Expired</b></span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('obd.bank.payment.approve', $list->id) }}">
                                                    <i class="fa fa-check-circle-o"
                                                        style="font-size:18px;"></i>&nbsp;Approve
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
