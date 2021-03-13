@extends('admin.layouts.default')
@section('title','Update Product')
@section('css')
<link rel="stylesheet" href="{{asset('admin/bootstrap-tagsinput.css')}}">
@endsection
@section('content')
@include('admin.includes.tabs')
<div class="tab-content">
    <div class="tab-pane container active " id="updateProduct">
@php
$productTags=$product->productTags;
@endphp      
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Product</li>
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
                <h3 class="card-title">Update Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ route('update-product',$product->id) }}" method="POST" enctype="multipart/form-data">
                {{@csrf_field()}}
                {{method_field('PUT') }}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('productName'))
                      @component('admin.components.error')
                        {{$errors->first('productName')}}
                      @endcomponent
                    @endif
                      <label>Product Name</label>
                      <input type="text" class="form-control" placeholder="Product Name" name="productName" value="{{$product->productName}}" required="true">
                    </div>
                    <div class="form-group">
                    @if($errors->has('productPrice'))
                      @component('admin.components.error')
                        {{$errors->first('productPrice')}}
                      @endcomponent
                    @endif
                      <label>Product Price</label>
                      <input type="text" class="form-control" placeholder="Product Price" name="productPrice" value="{{$product->price}}" required="true">
                    </div>
                    <div class="form-group">
                      @if($errors->has('description'))
                      @component('admin.components.error')
                        {{$errors->first('description')}}
                      @endcomponent
                        @endif
                      <label>Description</label>
                      <div class="mb-3">
                      <textarea class="textarea" placeholder="description"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description" value="{{old('description')}}" required="true">{{$product->description}}</textarea>
                      </div>
                    </div>
                    <div class="form-group">
                    @if($errors->has('category'))
                      @component('admin.components.error')
                        {{$errors->first('category')}}
                      @endcomponent
                    @endif
                      <label>Select Category</label>
                      <select class="custom-select" name="category">
                          @foreach($categories as $category)
                          <option value="{{$category->id}}" {{$product->product_category_id==$category->id ? 'selected' : ''}}>{{$category->categoryName}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                    <label for="exampleInputFile">Product Zip</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="zipFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  @if(count($product->productZipFiles) >0)
                  <div class="form-group">
                      <a href="{{asset('/product-templates/') .'/'.$product->productZipFiles[0]->file}}" class="btn btn-success" target="_blank">View Template</a>
                  </div>
                  @endif
                    <div class="form-group">
                        <label for="product_tags">Product Tags</label>
                        <input type="text" name="product_tags" id="product_tags" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Add Product Tags</label>
                        @foreach($tags as $tag)
                        <div class="single-product-tag">
                            <a href="javascript:;" class="add-tag-product" data-tag="{{$tag->id}}">{{$tag->tag_name}}</a>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        @if($errors->has('status'))
                            @component('admin.components.error')
                                {{$errors->first('status')}}
                            @endcomponent
                        @endif
                        <label for="status">Active
                        <input type="checkbox" name="status" id="status" class="" value="{{$product->status}}" {{$product->status==1 ? 'checked' : ''}}>
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
</div>
<div class="tab-pane container fade" id="productimages">
@include('admin.includes.product-images')
</div>
</div>
@endsection
@section('scripts')
<script src="{{asset('admin/bootstrap-tagsinput.js')}}"></script>
<script>
    jQuery(document).ready(function($) {
        $("#product_tags").tagsinput({
            itemValue: 'id',
            itemText:'tag'
        });
        $(document).on('click', '.add-tag-product', function(event) {
            let tagId=$(this).data('tag');
            let tag=$(this).text()
            $("#product_tags").tagsinput('add',{id:tagId,tag:tag})
        });
        let productTags=JSON.parse('{!!json_encode($productTags)!!}');
        if (productTags.length) {
            productTags.forEach( function(element, index) {
                $("#product_tags").tagsinput('add',{'id':element.id,'tag':element.tag_name})        
            });
        }

        var plupload=$("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : '{{route('upload-product-images',$product->id)}}',

        // User can upload no more then 20 files in one go (sets multiple_queues to false)
        max_file_count: 20,
        
        

        // Resize images on clientside if we can
        /*resize : {
            width : 200, 
            height : 200, 
            quality : 90,
            crop: true // crop to exact dimensions
        }*/
        
        filters : {
            // Maximum file size
            max_file_size : '10mb',
            // Specify what files to browse for
            mime_types: [
                {title : "Image files", extensions : "jpg,jpeg,png"}
            ]
        },

        // Rename files by clicking on their titles
        rename: true,
        
        // Sort files
        sortable: true,

        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,

        // Views to activate
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },

        // Flash settings
        flash_swf_url : '{{asset('admin/Moxie.swf')}}',

        // Silverlight settings
        silverlight_xap_url : '{{asset('admin/Moxie.xap')}}',
        multipart_params:{
            '_token':'{{csrf_token()}}',
            'model':'Product'
        },
        init:{
            FilesAdded:function(up,files){
                $('#uploader').plupload('start');
            },
            FileUploaded:function(up,file,result){
                let thumbId=file.id;
                $(`#${thumbId}`).attr('data-thumb', result.response)
                $(`#${thumbId}`).find('.plupload_action_icon').attr('data-thumb', thumbId)
                // console.log(result,file)
            }
        }
        
        });
        plupload.init();

$(document).on('click', '.plupload_action_icon,.delete-product-image', function(event) {
    let _data=$(this).data('thumb')
    let _thumbId=$(this).parents(`#${_data}`).data('thumb')
    $.ajax({
        url: '{{route('delete-product-image')}}',
        type: 'GET',
        data: {image: _thumbId},
        success:function(result){
            $(`#${_data}`).remove()
        }
    });
});
    });
</script>
@endsection
