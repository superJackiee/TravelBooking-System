<div class="card shadow-none mb-0 p-0 pb-1">
    <div class="card-header d-flex justify-content-between align-items-center border-bottom">
        <h6 class="mb-0">{{ $product->title }}</h6>
        <div class="app-file-action-icons d-flex align-items-center">
            <a href="{{ route('product_edit', ['product_id' => $product->id]) }}" style="color: #475F7B;">
                <i class="bx bx-edit cursor-pointer mr-50"></i>
            </a>
            <a href="{{ route('product_delete', ['product_id' => $product->id]) }}" style="color: #475F7B;">
                <i class="bx bx-trash cursor-pointer mr-50"></i>
            </a>
            <a href="javascript:void(0)" onclick="close_preview()" style="color: #475F7B;">
                <i class="bx bx-x close-icon cursor-pointer"></i>
            </a>
        </div>
    </div>
    <div class="card-content">
        <div class="card-body pt-2">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                    @foreach($product->getGallery as $item)
                    @if($loop->index == 0)
                    <li data-target="#carousel-example-generic" data-slide-to="{{ $loop->index }}" class="active"></li>
                    @else
                    <li data-target="#carousel-example-generic" data-slide-to="{{ $loop->index }}"></li>
                    @endif
                    @endforeach
              </ol>
              <div class="carousel-inner" role="listbox">
                    @foreach($product->getGallery as $item)
                    @if($loop->index == 0)
                    <div class="carousel-item active">
                        <img class="img-fluid" src="{{asset($item->path)}}" alt="First slide" style="width: 100%; height: 300px; object-fit: cover;">
                    </div>
                    @else
                    <div class="carousel-item">
                        <img class="img-fluid" src="{{asset($item->path)}}" alt="Second slide" style="width: 100%; height: 300px; object-fit: cover;">
                    </div>
                    @endif
                    @endforeach
              </div>
              <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>

            <label class="app-file-label">Information</label>
            <div class="d-flex align-items-center mt-75">
                <p style="margin-right: 20px;" class="text-danger">Category:</p>
                <p class="font-weight-bold">{{ $product->getCategory->title }}</p>
            </div>
            <div class="d-flex align-items-center">
                <p style="margin-right: 20px;" class="text-danger">location:</p>
                <p class="font-weight-bold">{{ $product->getCountry->title }} {{ $product->getCity->title }} ({{ $product->location }})</p>
            </div>
            <input type="hidden" id="location_info" value="{{ $product->location }}">
            <div id="basic-map" class="height-300"></div>
            <div class="d-flex align-items-center mt-75">
                <p style="margin-right: 20px;" class="text-danger">Serving Time:</p>
                <p class="font-weight-bold">{{ $product->start_time }} ~ {{ $product->end_time }}</p>
            </div>
            <div>
                <p style="margin-right: 20px;" class="text-danger">Description</p>
                @foreach($product->getDescription as $item)
                <div class="d-flex align-items-center justify-content-between">
                    <p class="font-weight-bold">{{ $item->getLang->name }}</p>
                    <div class="avatar mr-1 avatar-lg">
                        <img src="{{ asset('images/flags/'.$item->language.'.png')}}" alt="avtar img holder" class="flag">
                    </div>
                </div>
                <div>
                    <?php echo $item->description ?>
                </div>
                @endforeach
            </div>
            <div>
                <p style="margin-right: 20px;" class="text-danger">Pricing:</p>
                @for($i=0; $i<count($product_pricing); $i++)
                  <div style="border: 1px solid #ddd;" class="mb-1 pl-1">
                    <div class="d-flex align-items-center mt-75 mb-1">
                      <p class="font-weight-bold mr-1 text-primary">{{ $product_pricing[$i]['duration'] }}</p>
                      <p class="font-weight-bold text-primary">{{ $pricing_model->getCurr($product_pricing[$i]['currency'])->title }}</p>
                    </div>
                    @php
                      $pricing_sub_data = $product_pricing[$i]['pricing_data'];
                    @endphp
                    @for($j=0; $j<count($pricing_sub_data); $j++)
                      <div class="d-flex align-items-center mt-75 mb-1">
                        <p class="font-weight-bold mr-1">{{ $pricing_model->getTagg($pricing_sub_data[$j]['tag'])->title }}</p>
                        <p class="font-weight-bold">{{ $pricing_sub_data[$j]['price'] }}({{ $pricing_model->getCurr($product_pricing[$i]['currency'])->title }})</p>
                      </div>
                    @endfor
                  </div>
                @endfor
            </div>
        </div>
    </div>
</div>
