@extends('admin.layouts.default')
@section('title','Add Category')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add New Category</li>
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
                <h3 class="card-title">Create Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ route('create-product-category') }}" method="POST" enctype="multipart/form-data">
                {{@csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('categoryName'))
                      @component('admin.components.error')
                        {{$errors->first('categoryName')}}
                      @endcomponent
                    @endif
                      <label>Category Name</label>
                      <input type="text" class="form-control" placeholder="Category Name" name="categoryName" value="{{old('categoryName')}}" required="true">
                    </div>
                    <div class="form-group">
                      @if($errors->has('status'))
                          @component('admin.components.error')
                            {{$errors->first('status')}}
                          @endcomponent
                        @endif
                    <label for="status">Active
                      <input type="checkbox" name="status" id="status" class="" value="{{old('status')}}">
                    </label>
            </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Save</button>
                  <a href="{{URL::previous()}}" class="btn  bg-gradient-info">Back</a>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</section>
@endsection
