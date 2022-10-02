@extends('portal.layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Reply Ticket</h3>

            <div class="box-tools">
              <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                <div class="input-group-btn">
                  <a href="{{ route('ticket.list') }}">
                    <button type="button" class="btn btn-primary btn-sm pull-right">
                      <i class="fa fa-ticket" aria-hidden="true"></i> Ticket List
                    </button>
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

              <form method="POST" action="{{ route('ticket.update') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="ticket_id" value="{{ $ticketDetail->id }}">
                <div class="box-body">
                  <div class="row">
                    <div class="form-group col-sm-4">
                      <label for="username">Username</label>
                      <div>{{ $ticketDetail->getUser->username }}</div>
                      <!-- <input type="text" class="form-control" value="{{ $ticketDetail->getUser->username }}" disabled> -->
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="email">Email</label>
                      <div>{{ $ticketDetail->getUser->email }}</div>
                      <!-- <input type="text" class="form-control" value="{{ $ticketDetail->getUser->email }}" disabled> -->
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="mobile_no">Mobile No.</label>
                      <div>{{ $ticketDetail->getUser->mobile_no ? $ticketDetail->getUser->mobile_no : 'N/A' }}</div>
                      <!-- <input type="text" class="form-control" value="{{ $ticketDetail->getUser->mobile_no ? $ticketDetail->getUser->mobile_no : 'N/A' }}" disabled> -->
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="subject">Subject</label>
                    <div>{{ $ticketDetail->subject }}</div>
                    <!-- <input type="text" class="form-control" name="subject" placeholder="Enter Subject" value="{{ $ticketDetail->subject }}" disabled> -->
                  </div>
                  <!-- <div class="form-group">
                    <label for="details">Details</label>
                    <textarea rows="10" class="form-control" name="details" placeholder="Enter Details" disabled>{{ $ticketDetail->details }}</textarea>
                  </div> -->

                  <div class="direct-chat-primary">
                    <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix row">
                          <span class="direct-chat-name col-sm-6"><b>User</b></span>
                          <span class="direct-chat-timestamp col-sm-6 text-right">{{ date('d M, Y h:i A', strtotime($ticketDetail->created_at)) }}</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" style="border: 2px solid black;" src="{{ asset('assets/user.png') }}" alt="Message User Image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          {{ $ticketDetail->details }}
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    @foreach($threadDetail as $thread)
                      @if($thread->sender == 'user')
                      <div class="direct-chat-msg">
                          <div class="direct-chat-infos clearfix row">
                            <span class="direct-chat-name col-sm-6"><b>User</b></span>
                            <span class="direct-chat-timestamp col-sm-6 text-right">{{ date('d M, Y h:i A', strtotime($thread->created_at)) }}</span>
                          </div>
                          <!-- /.direct-chat-infos -->
                          <img class="direct-chat-img" style="border: 2px solid black;" src="{{ asset('assets/user.png') }}" alt="Message User Image">
                          <!-- /.direct-chat-img -->
                          <div class="direct-chat-text">
                            {{ $thread->message }}
                          </div>
                          <!-- /.direct-chat-text -->
                      </div>
                      @else
                      <div class="direct-chat-msg right">
                          <div class="direct-chat-infos clearfix row">
                            <span class="direct-chat-timestamp col-sm-6">{{ date('d M, Y h:i A', strtotime($thread->created_at)) }}</span>
                            <span class="direct-chat-name col-sm-6 text-right"><b>Admin</b></span>
                          </div>
                          <!-- /.direct-chat-infos -->
                          <img class="direct-chat-img" style="border: 2px solid black;" src="{{ asset('assets/user.png') }}" alt="Message User Image">
                          <!-- /.direct-chat-img -->
                          <div class="direct-chat-text">
                            {{ $thread->message }}
                          </div>
                          <!-- /.direct-chat-text -->
                      </div>
                      @endif
                    @endforeach
                  </div>
                  <div class="form-group">
                    <label for="reply">Reply</label>
                    <textarea rows="10" class="form-control" name="reply" placeholder="Enter Reply"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="is_resolved">Is Resolved?</label>
                    <div class="radio">
                      <label>
                        <input type="radio" name="is_resolved" value="1" {{ $ticketDetail->is_resolved == 1 ? 'checked' : '' }}>
                        Yes
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="is_resolved" value="0" {{ $ticketDetail->is_resolved == 0 ? 'checked' : '' }}>
                        No
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