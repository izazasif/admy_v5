@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Web API Purchase History</h3>
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
                                    <th class="text-center">Acquisition</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Payment Status</th>
                                    <th class="text-center">Creation Time</th>
                                    <th class="text-center">Status</th>
                                </tr>
                                @php $sl=1 @endphp
                                @php $sl = ($lists->currentpage()-1)* $lists->perpage()+1 @endphp
                                @foreach( $lists as $list)
                                    <tr>
                                        <td class="text-center">{{ $sl++ }}</td>
                                        <td class="text-center">{{ $list->acquisition }}</td>
                                        <td class="text-center">{{ $list->price }}</td>
                                        <td class="text-center">{{ $list->payment_status }}</td>
                                        <td class="text-center">{{ date('d-m-Y h:i A', strtotime($list->created_at)) }}</td>
                                        <td class="text-center">
                                            @if($list->status)
                                                <span style="color:green"><b><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Active</b></span>
                                            @else
                                                <span style="color:red"><b><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp In Active</b></span>
                                            @endif
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
