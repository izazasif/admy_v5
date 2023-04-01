@extends('portal.layouts.master')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-10 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Campaing Stat</h3>
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
                                    <th class="text-center">Sent</th>
                                    <th class="text-center">Delivered</th>
                                    <th class="text-center">Conversions</th>
                                    <th class="text-center">Parked</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Effective Scheduled Date</th>

                                </tr>
                                @php
                                    $sl = 1;
                                    $statusText = ($status === 1) ? 'CREATED' :
                                        (($status === 2) ? 'RUNNING' :
                                        (($status === 3) ? 'PAUSED' :
                                        (($status === 4) ? 'ENDED' :
                                        (($status === 6) ? 'SCHEDULED' : ''))));
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $sl++ }}</td>
                                    <td class="text-center">{{ $stat->sent }}</td>
                                    <td class="text-center">{{ $stat->delivered }}</td>
                                    <td class="text-center">{{ $stat->conversions }}</td>
                                    <td class="text-center">{{ $stat->parked }}</td>
                                    <td class="text-center">
                                        {{ $statusText }}
                                    </td>
                                    <td class="text-center">
                                        {{ $effectiveScheduledDate == 0 ? '' : date('Y-m-d', strtotime($effectiveScheduledDate)) }}
                                    </td>
                                </tr>

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
