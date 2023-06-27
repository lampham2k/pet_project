@extends('layout_frontpage.master')
@section('content')
<div class="main main-raised">
   <div class="section"></div>
   <div class="section">
      <div class="container">
         <h2 class="section-title">{{ __('frontpage.filter_title_sidebar') }}</h2>
         <div class="row">
            <div class="col-md-3">
               <div class="card card-refine card-plain">
                  <div class="card-content">
                     <form>
                     <h4 class="card-title">
                        {{ __('frontpage.refine') }} 
                        <button class="btn btn-default btn-fab btn-fab-mini btn-simple pull-right" rel="tooltip" title="" data-original-title="Reset Filter">
                        <i class="material-icons">cached</i>
                        </button>
                     </h4>
                     <div class="panel panel-default panel-rose">
                        <div class="panel-heading" role="tab" id="headingOne">
                           <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                              <h4 class="panel-title">{{ __('frontpage.price_range') }}</h4>
                              <i class="material-icons">keyboard_arrow_down</i>
                           </a>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                           <input type="hidden" name="min_price" value="{{ $minPrice }}" id="input-min-price">
                           <input type="hidden" name="max_price" value="{{ $maxPrice }}" id="input-max-price">
                           <div class="panel-body panel-refine">
                              <span class="pull-left">
                                 ₫<span id="span-min-price">
                                    {{ $minPrice }}
                                 </span>
                              </span>
                              <span class="pull-right">
                                 ₫<span id="span-max-price">
                                    {{ $maxPrice }}
                                 </span>
                              </span>
                              <div class="clearfix"></div>
                              <div id="sliderRefine" class="slider slider-rose noUi-target noUi-ltr noUi-horizontal">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-default panel-rose">
                        <div class="panel-heading" role="tab" id="headingTwo">
                           <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              <h4 class="panel-title">{{ __('frontpage.types') }}</h4>
                              <i class="material-icons">keyboard_arrow_down</i>
                           </a>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                           <div class="panel-body">
                              @foreach ($types as $key => $value )
                              <div class="checkbox">
                                 <label>
                                 <input type="checkbox" value="{{ $key }}" data-toggle="checkbox" name="types[]" @if (in_array($key, $arrTypeIdFilters)) 
                                    checked
                                 @endif><span class="checkbox-material"><span class="check"></span></span>
                                    {{ $value }}
                                 </label>
                              </div>
                              @endforeach
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-default panel-rose">
                        <div class="panel-heading" role="tab" id="headingThree">
                           <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              <h4 class="panel-title">{{ __('frontpage.Brand') }}</h4>
                              <i class="material-icons">keyboard_arrow_down</i>
                           </a>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                           <div class="panel-body">
                              @foreach ($manufacturers as $each )
                              <div class="checkbox">
                                 <label>
                                 <input type="checkbox" value="{{ $each->id }}" data-toggle="checkbox" name="manufacturers[]" @if (in_array($each->id, $arrManufacturerFilters)) 
                                 checked
                              @endif><span class="checkbox-material"><span class="check"></span></span>
                                    {{ $each->name }}
                                 </label>
                              </div>
                              @endforeach
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-default panel-rose">
                        <div class="panel-heading" role="tab" id="headingFour">
                           <div class="togglebutton">
                              <label>
                                  <input type="checkbox" name="discount"@if (isset($discount)) 
                                  checked
                               @endif><span class="toggle"></span>
                                  {{ __('frontpage.Discounts') }}
                              </label>
                           </div>
                           {{-- <input type="checkbox" name="product_discount"><span class="checkbox-material"><span class="check"></span></span><h4 class="panel-title">{{ __('frontpage.Discounts') }}</h4> --}}
                        </div>
                     </div>
                     </form>
                  </div>
               </div>
               <!-- end card -->
            </div>
            <div class="col-md-9">
               <div class="row">
                  @foreach ($data as $each)
                  @if (in_array($each->id, $arrDataAllIdDistinct))
                  <div class="col-md-4">
                     <div class="card card-product card-plain no-shadow" data-colored-shadow="false">
                        <a href="{{ route('customer.product', $each->id) }}">
                        <div class="card-image">
                              <img src="{{ asset("storage/product_photo/".$each->photo) }}" style="width:200px !important; height:200px !important;">
                           </div>
                           <div class="card-content">
                              <h4 class="card-title">{{ $each->name }}</h4>
                              <p class="description">
                              </p>
                        </a>
                           <div class="footer">
                              @if (isset($each->max_discount_percent))
                              <div class="price-container">
											<span class="price price-old">{{ $each->price }} đ</span>
                                 <span class="price price-new">{{ $each->price_new }} đ</span>
										</div>
                              @else
                              <div class="price-container">
											<span class="price">{{ $each->price }} đ</span>
										</div>
                              @endif
                              <button class="btn btn-rose btn-simple btn-fab btn-fab-mini btn-round pull-right" rel="tooltip" title="" data-placement="left" data-original-title="Remove from wishlist">
                              <i class="material-icons">favorite</i>
                              </button>
                           </div>
                        </div>
                     </div>
                     <!-- end card -->
                  </div>
                  @endif
                  @endforeach
                  <ul class="pagination pagination-info" style="float:right !important;">
                     {{ $data->links() }}
                  </ul>
               </div>
            </div>
         </div>
         <br>
      </div>
   </div>
   <!-- section -->
</div>
@endsection
@push('js')
<script type="text/javascript">
   $(document).ready(function () {

      const slider2 = document.getElementById('sliderRefine');
      const minPrice = parseInt($("#input-min-price").val());
      const maxPrice = parseInt($("#input-max-price").val());
    
        noUiSlider.create(slider2, {
            start: [minPrice, maxPrice],
            step: 50000,
            connect: true,
            range: {
               'min': [ {{ $configs['min_price'] }} ],
               'max': [ {{ $configs['max_price'] }} + 500000 ],
            }
        });
    
        let val;
        
        slider2.noUiSlider.on('update', function( values, handle ){
          val = Math.round(values[handle]);
            if (handle){
             $('#span-max-price').text(val);
             $('#input-max-price').val(val);
            } else {
             $('#span-min-price').text(val);
             $('#input-min-price').val(val);
            }
        });
   });
</script>
@endpush