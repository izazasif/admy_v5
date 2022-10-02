@extends('portal.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Edit SMS Package</h3>
                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <a href="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                                <form method="POST" action="{{ route('portal.sms.update') }}" enctype="multipart/form-data">
                                    <input type="hidden" name="sms_id" value="{{ $smsDetail->id }}">
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ $smsDetail->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="category">SMS category</label>
                                            <select name="sms_category" class="form-control" id="category">
                                                <option value="">Select a sms category</option>
                                                <option value="bulk" {{ ($smsDetail->sms_category=='bulk') ? 'selected' : '' }}>Bulk SMS</option>
                                                <option value="push" {{ ($smsDetail->sms_category=='push') ? 'selected' : '' }}>Push SMS</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="category">SMS Type</label>
                                            <select name="sms_type" class="form-control" id="type">
                                                <option value="">Select a sms type</option>
                                                <option value="Musking" {{ ($smsDetail->sms_type=='Musking') ? 'selected' : '' }}>Musking SMS</option>
                                                <option value="Non-musking" {{ ($smsDetail->sms_type=='Non-musking') ? 'selected' : '' }}>Non-Musking SMS</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="unit_price">Unit Price</label>
                                            <input type="number" step="0.0000001" min=0 class="form-control" name="unit_price" placeholder="Enter Unit Price" value="{{ $smsDetail->unit_price }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="number" min=0 class="form-control" name="amount" placeholder="Enter Amount" value="{{ $smsDetail->amount }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Total Price</label>
                                            <input type="number" min=0 class="form-control" name="price" placeholder="Enter Total Price" value="{{ $smsDetail->price }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="validity">Validity</label>
                                            <input type="number" class="form-control" name="validity" placeholder="Enter Validity" value="{{ $smsDetail->validity }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="1" {{ $smsDetail->status == 1 ? 'checked' : '' }}>
                                                    Active
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="0" {{ $smsDetail->status == 0 ? 'checked' : '' }}>
                                                    Inactive
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
