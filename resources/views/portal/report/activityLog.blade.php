@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Activity Log</h3>
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
                                    <th class="text-center">Module</th>
                                    <th class="text-center">Module Activity</th>
                                    <th class="text-center">Data Created/Changed</th>
                                    <th class="text-center">Username </th>
                                    <th class="text-center">User Email </th>
                                </tr>
                                @php $sl = ($data->currentpage()-1)* $data->perpage()+1 @endphp
                                @foreach ($data as $val)
                                    <tr>
                                        <td class="text-center">{{ $sl++ }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($val->created_at)) }}</td>
                                        <td class="text-center">{{ $val->module_name }}</td>
                                        <td class="text-center">{{ $val->module_activity }}</td>
                                        <td class="text-center">{{ $val->user_data }}</td>
                                        <td class="text-center">{{ $val->username }}</td>
                                        <td class="text-center">{{ $val->email }}</td>

                                    </tr>
                                @endforeach
                            </table>
                            <div class="text-center">
                                {{ $data->links() }}
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
