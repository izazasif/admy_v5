@extends('portal.layouts.master')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Create SMS Text</h3>

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
                                        <ul class="text-left" style="list-style-type: none; padding-left: 0px;"><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            @foreach ($errors->all() as $error)
                                                <li><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> &nbsp;{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('message'))
                                    <div class="alert alert-success text-left">
                                        <ul style="list-style-type: none; padding-left: 0px;">
                                            <li>
                                                <a  class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> &nbsp;{{ session('message') }}
                                            </li>
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('sms.text.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="category_id">Category</label>
                                            <select class="form-control" name="category_id" id="category_id">
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="sms_text">SMS Text</label>
                                            <textarea name="text" class="form-control" id="sms_text">{{ old('text') }}</textarea>
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
