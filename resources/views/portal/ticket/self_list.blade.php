@extends('portal.layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">My Ticket List</h3>

            <div class="box-tools">
              <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                <div class="input-group-btn">
                  <a href="{{route('ticket.create')}}">
                    <button type="button" class="btn btn-primary btn-sm pull-right">
                      <i class="fa fa-plus" aria-hidden="true"></i> &nbsp;Create Ticket
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
            <table class="table table-bordered table-hover" style="margin-top:20px; margin-bottom:30px; table-layout:fixed;">
              <tr>
                <th class="col-sm-1 text-center">SL</th>
                <th class="col-sm-1 text-center">Message Alert</th>
                <th class="col-sm-3">Subject</th>
                <th class="col-sm-4">Details</th>
                <th class="col-sm-1 text-center">Is Resolved?</th>
                <th class="col-sm-1 text-center">Action</th>
              </tr>
              @php $sl = ($tickets->currentpage()-1)* $tickets->perpage()+1 @endphp
              @foreach( $tickets as $ticket ) 
              <tr class="{{$ticket->user_seen ? '' : 'highlight-ticket'}}">
                <td class="text-center">{{ $sl++ }}</td>
                <td class="text-center">
                  @if(!$ticket->user_seen)
                  <i class="fa fa-envelope" aria-hidden="true" style="color: goldenrod; font-size: 24px;"></i>
                  @endif
                </td>
                <td>{{ $ticket->subject }}</td>
                <td>{{ $ticket->details }}</td>
                <td class="text-center">
                  @if($ticket->is_resolved) 
                    <span style="color:green"><b><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Yes</b></span>
                  @else
                    <span style="color:red"><b><i class="fa fa-times" aria-hidden="true"></i>&nbsp;No</b></span>
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{route('ticket.edit.self',$ticket->id)}}">
                    <button type="button" class="btn btn-primary btn-sm">
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Reply
                    </button>
                  </a>
                </td>
              </tr>
              @endforeach
            </table>
            <div class="text-center">
              {{ $tickets->links() }}
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