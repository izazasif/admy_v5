@extends('portal.layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-sm-6 col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Category List</h3>

            <div class="box-tools">
              <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                <div class="input-group-btn">
                  <a href="{{route('category.create')}}">
                    <button type="button" class="btn btn-primary btn-sm pull-right">
                      <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;Create Category
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
                <th class="text-center">Title</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
              @php $sl = ($categories->currentpage()-1)* $categories->perpage()+1 @endphp
              @foreach( $categories as $category ) 
              <tr>
                <td class="text-center">{{ $sl++ }}</td>
                <td class="text-center">{{ $category->title }}</td>
                <td class="text-center">
                  @if($category->status) 
                    <span style="color:green"><b><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Active</b></span>
                  @else
                    <span style="color:red"><b><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Inactive</b></span>
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{route('category.edit',$category->id)}}">
                    <button type="button" class="btn btn-primary btn-sm">
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                    </button>
                  </a>
                </td>
              </tr>
              @endforeach
            </table>
            <div class="text-center">
              {{ $categories->links() }}
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