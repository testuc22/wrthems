@extends('admin.layouts.default')
@section('title','Edit Tag')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Tag</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Tag</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header bg-info text-white">
                <h3 class="card-title">Edit Tag</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('update-tag',$tag->id)}}" method="POST" enctype="multipart/form-data">
                  {{@csrf_field()}}
                  {{@method_field('PUT')}}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('tag_title'))
                      @component('admin.components.error')
                        {{$errors->first('tag_title')}}
                      @endcomponent
                    @endif
                      <label>Title</label>
                      <input type="text" class="form-control" placeholder="Title" name="tag_title" value="{{$tag->tag_name}}" required="true">
                    </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="{{URL::previous()}}" class="btn  bg-gradient-success">Back</a>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</section>
@endsection
