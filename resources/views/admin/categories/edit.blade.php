@extends('admin.layouts.default')
@section('title','Update Category')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Category</li>
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
                <h3 class="card-title">Edit Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ route('update-product-category',$category->id) }}" method="POST" enctype="multipart/form-data">
                {{@csrf_field()}}
                {{method_field('PUT') }}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('categoryName'))
                      @component('admin.components.error')
                        {{$errors->first('categoryName')}}
                      @endcomponent
                    @endif
                      <label>Category Name</label>
                      <input type="text" class="form-control" placeholder="Category Name" name="categoryName" value="{{$category->categoryName}}" required="true">
                    </div>
                    <div class="form-group">
                      @if($errors->has('status'))
                          @component('admin.components.error')
                            {{$errors->first('status')}}
                          @endcomponent
                        @endif
                    <label for="status">Active
                      <input type="checkbox" name="status" id="status" class="" value="{{$category->status}}" {{ $category->status==1 ? 'checked' : ''}}>
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
