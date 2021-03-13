<form id="form" method="post">
    <div id="uploader">
        
    </div>
</form>
<div>
    <div class="row">
        @if(count($product->productFiles) > 0)
        @foreach($product->productFiles as $file)
        @if($file->fileType!="zip")
        <div class="col-md-4" id="{{$file->id}}" data-thumb="{{$file->id}}">
            <div class="product-image">
                <img src="{{asset('/product-files/') .'/'.$file->file}}" height="200" width="200">
            </div>
            <div class="delete-product-image-wrap">
                <a href="javascript:;" data-thumb="{{$file->id}}" class="delete-product-image"><i class="fas fa-times-circle"></i></a>
            </div>
        </div>
        @endif
        @endforeach
        @endif
    </div>
</div>