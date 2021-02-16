@if($flag == 'no')
<div class="row app-file-recent-access" id="product_list">
    @foreach($product as $item)
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="card border shadow-none mb-1 app-file-info p-act" onclick="get_detail({{ $item->id }})">
        <div class="card-content">
            <div class="app-file-content-logo card-img-top act-image" style="background: url({{asset($item->getFirstImage?$item->getFirstImage->path:'')}})">
            <i class="bx bx-dots-vertical-rounded app-file-edit-icon d-block float-right"></i>
            </div>

            <div class="card-body p-50">
            <div class="app-file-recent-details">
                <div class="app-file-name font-size-small font-weight-bold ml-25">{{ $item->title?$item->title:'' }}</div>
                <div class="app-file-size font-size-small text-primary mb-25 ml-25">{{ $item->getCategory?$item->getCategory->title:''  }}</div>
                <div class="app-file-size font-size-small text-muted mb-25 ml-25">{{ $item->getCountry?$item->getCountry->title:'' }} {{  $item->getCity?$item->getCity->title:'' }}</div>
                <div class="app-file-last-access font-size-small text-danger ml-25">{{ $item->start_time?$item->start_time: '' }} ~ {{ $item->end_time?$item->end_time: '' }}</div>
            </div>
            </div>
        </div>
        </div>
    </div>
    @endforeach
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-end">
        <div id="product_pagination" class="product_pagination">
            {{ $product->onEachSide(5)->links() }}
        </div>
    </div>
</div>
@else
<div class="row app-file-recent-access" id="product_list">
    @foreach($product as $item)
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="card border shadow-none mb-1 app-file-info p-act" onclick="get_detail({{ $item->id }})">
        <div class="card-content">
            @php 

                $product_gallery = $product_gallery_model->where('product_id', $item->id)->first();
                $path = $product_gallery?$product_gallery->path:'';
            @endphp
            <div class="app-file-content-logo card-img-top act-image" style="background: url({{asset($path)}})">
            <i class="bx bx-dots-vertical-rounded app-file-edit-icon d-block float-right"></i>
            </div>

            <div class="card-body p-50">
            <div class="app-file-recent-details">
                <div class="app-file-name font-size-small font-weight-bold ml-25">{{ $item->title?$item->title:'' }}</div>
                <div class="app-file-size font-size-small text-primary mb-25 ml-25">{{ $item->category_title?$item->category_title:''  }}</div>
                <div class="app-file-size font-size-small text-muted mb-25 ml-25">{{ $item->country_title?$item->country_title:'' }} {{  $item->city_title?$item->city_title:'' }}</div>
                <div class="app-file-last-access font-size-small text-danger ml-25">{{ $item->start_time?$item->start_time: '' }} ~ {{ $item->end_time?$item->end_time: '' }}</div>
            </div>
            </div>
        </div>
        </div>
    </div>
    @endforeach
</div>
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3 col-sm-6">
        <div id="product_pagination" class="product_pagination" style="float: right;">
            {{ $product->onEachSide(5)->links() }}
        </div>
    </div>
</div>
@endif