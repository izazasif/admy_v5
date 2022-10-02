@extends('portal.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">SMS List</h3>
                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="{{route('portal.sms.create')}}">
                                            <button type="button" class="btn btn-primary btn-sm pull-right">
                                                <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;Create SMS Pack
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
                                        <a  class="close" data-dismiss="alert" aria-label="close">&times;</a>
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
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center">Validity</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                @php $sl = ($sms->currentpage()-1)* $sms->perpage()+1 @endphp
{{--                                @php $sl = 1 @endphp--}}
                                @foreach( $sms as $value )
                                    <tr>
                                        <td class="text-center">{{ $sl++ }}</td>
                                        <td class="text-center">{{ $value->name }}</td>
                                        <td class="text-center">{{ $value->unit_price }} Taka</td>
                                        <td class="text-center">{{ $value->amount }}</td>
                                        <td class="text-center">{{ $value->price }} Taka</td>
                                        <td class="text-center">{{ $value->validity }} Days</td>
                                        <td class="text-center">
                                            @if($value->status)
                                                <span style="color:green"><b><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Active</b></span>
                                            @else
                                                <span style="color:red"><b><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Inactive</b></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('portal.sms.edit',$value->id)}}">
                                                <button type="button" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="text-center">
                                {{ $sms->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
