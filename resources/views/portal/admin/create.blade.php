@extends('portal.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Create Admin User</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="">
                                            <!-- <button type="button" class="btn btn-primary btn-sm pull-right">
                                                  <i class="fa fa-users" aria-hidden="true"></i> All Categories
                                                </button> -->
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div class="panel-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="text-left" style="list-style-type: none; padding-left: 0px;"><a
                                                class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            @foreach ($errors->all() as $error)
                                                <li><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                                                    &nbsp;{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('message'))
                                    <div class="alert alert-success text-left">
                                        <ul style="list-style-type: none; padding-left: 0px;">
                                            <li>
                                                <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                &nbsp;{{ session('message') }}
                                            </li>
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" name="username"
                                                placeholder="Enter Username" value="{{ old('username') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter Email" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter Password" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password"
                                                placeholder="Enter Confirm Password" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="user_permission">Permission</label>
                                            <select class="form-control" name="user_permission" id="user_permission">
                                                <option value="">-- Select Role --</option>
                                                <option value="all">Super Admin</option>
                                                <option value="ticket">Ticket Admin</option>
                                                <option value="financial">Financial Admin</option>
                                                <option value="report">Reporting Admin</option>
                                                <option value="obd_sms_manager">OBD SMS Manager</option>
                                                <option value="obd_sms_viewer">OBD SMS Viewer</option>
                                                <option value="obd_creator">OBD Manager</option>
                                                <option value="obd_viewer">OBD Viewer</option>
                                                <option value="sms_creator">Push SMS Manager</option>
                                                <option value="sms_viewer">Push SMS Viewer</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="1" checked>
                                                    Active
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="0">
                                                    Inactive
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

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
