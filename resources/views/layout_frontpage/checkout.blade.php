@extends('layout_frontpage.master')
@push('css')
<style>
.section {
   padding-bottom: 3px !important;
   padding-top: 70px !important;
   padding-left: 15px !important;
}
.icon {
   position: relative;
   top: -31px;         
}
.btn-address {
   position: relative;
   top: -4px;         
   left: 10px;         
}
/* table, th, td {
  border: 1px solid;
} */
.edit-address{
   vertical-align: top;
   text-align: left; 
   /* padding-left: 30px; */
}
.optionRadios{
   vertical-align: top;
   text-align: left; 
   /* padding-left: 30px; */
}

select {
   appearance: none;
   outline: 0;
   border: 0;
   box-shadow: none;
   flex: 1;
   padding: 0 1em;
   color: #fff;
   background-color: #2c3e50;
   background-image: none;
   cursor: pointer;
}
.select-city {
   position: relative;
   display: flex;
   width: 10em;
   height: 3em;
   border-radius: .25em;
   overflow: hidden;
   top: -5px;         
   left: 51px;
}
.select-city::after {
   content: '\25BC';
   position: absolute;
   top: 0;
   right: 0;
   padding: 1em;
   background-color: #34495e;
   transition: .25s all ease;
   pointer-events: none;
}
.select-city:hover::after {
   color: #f39c12;
}
.select-district {
   position: relative;
   display: flex;
   width: 10em;
   height: 3em;
   border-radius: .25em;
   overflow: hidden;
   top: -47px;         
   left:212px;
}
.select-district::after {
   content: '\25BC';
   position: absolute;
   top: 0;
   right: 0;
   padding: 1em;
   background-color: #34495e;
   transition: .25s all ease;
   pointer-events: none;
}
.select-district:hover::after {
   color: #f39c12;
}
</style>
@endpush
@section('content')
<div class="section">
   <div class="icon icon-primary" style="display: inline !important;">
      <i class="material-icons">pin_drop</i>
   </div>
   <div class="description" style="display: inline-block !important;">
      <h4 class="info-title">Delivery address</h4>
      @if (empty($addressDefault))
      <p style="font-size: 20px; !important;">Empty</p>
      @else
      <p style="font-size: 20px; !important;"> {{ $addressDefault['full_name'] }} (+84) {{ $addressDefault['phone_number'] }}
         {{ $addressDefault['street'] }}, {{ $addressDefault['district'] }}, {{ $addressDefault['city'] }}</p>
      @endif
   </div>
   <button class="btn btn-xs btn-address">default</button>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-info btn-xs btn-address" data-toggle="modal" data-target="#addressModal">
      change
   </button>
</div>
<div class="row">
    <div class="col-md-12">
       <h3 style="padding-left: 50px; !important;">Shopping / Checkout</h3>
    </div>
    <div class="col-md-10 col-md-offset-1">
       <div class="table-responsive">
          <table class="table table-shopping">
             <thead>
                <tr>
                   <th class="text-center"></th>
                   <th>Product</th>
                   <th class="th-description">Size</th>
                   <th class="text-right">Price</th>
                   <th class="text-right">Qty</th>
                   <th class="text-right">Amount</th>
                   <th></th>
                </tr>
             </thead>
             <tbody>
               <form action="{{ route('customer.place-order') }}" method="GET">
                  <input type="hidden" name="total" value="{{ $total }}">
                @foreach ($myCart as $idProduct => $eachValueProduct )
                    @if (in_array($idProduct, $arrIdProductCheckout))
                    <input type="hidden" value="{{ $idProduct }}" name="id[]">
                    <tr>
                        <td>
                           <div class="img-container">
                              <img src="{{ asset("storage/product_photo/".$eachValueProduct['photo_product']) }}">
                           </div>
                        </td>
                        <td class="td-name">
                           <a href="" style="color:#000000 !important;">{{ $eachValueProduct['name_product'] }}</a>
                        </td>
                        <td>
                           {{ $eachValueProduct['size'] }}
                        </td>
                        <td class="td-number">
                           {{ $eachValueProduct['price'] }}<small>đ</small>
                        </td>
                        <td class="td-number quantity">
                           <p class= "p-quantity" style="display: inline; !important;">{{ $eachValueProduct['quantity'] }}</p>
                        </td>
                        <td class="td-number">
                           <p class= "p-amount" style="display: inline; !important;">{{ $eachValueProduct['amount'] }}</p><small>đ</small>
                        </td>
                     </tr>
                    @endif
                @endforeach
                <tr class="tr-total">
                   <td colspan="3">
                   </td>
                   <td class="td-total">
                      Total
                   </td>
                   <td class="td-price">
                     <p class= "p-total" style="display: inline; !important;">{{ $total }}</p><small>đ</small>
                   </td>
                   <td colspan="3" class="text-right"> <button class="btn btn-info btn-round">Place Order <i class="material-icons">keyboard_arrow_right</i></button></td>
                </tr>
               </form>
             </tbody>
          </table>
       </div>
    </div>
 </div>
 <!-- Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">My address</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="modal-body list-address">
            @if (!isset($myArrAddress))
               <p>Empty</p>
            @else
            <table style="width: 100% !important;">
               @foreach ($myArrAddress as $idAddress => $each)
                  <tr class="tr-address-detail">
                     <input type="hidden" value="{{ $idAddress }}" class="input-id">
                     <td class="optionRadios">
                        <div class="radio">
                           <label>
                              <input type="radio" value="{{ $idAddress }}" class="radio-default-address" name="default"@if ($each['default'] === 1)
                                 checked="true"
                              @endif><span class="circle"></span><span class="check"></span>
                           </label>
                        </div>
                     </td>
                     <td>
                        <b>{{ $each['full_name'] }}</b> | <p style="display: inline; !important;">{{ $each['phone_number'] }}</p>
                        <p>{{ $each['street'] }}, {{ $each['district'] }}, {{ $each['city'] }}</p>                  
                     </td>
                     <td class="edit-address">
                        <a href="#" class="a-edit-address">Edit</a>
                     </td>
                  </tr>
               @endforeach
            </table>
            @endif
            <button class="btn btn-xs btn-raised btn-round btn-add-new-address" data-toggle="modal" data-target="#formNewAddressModal">
               <i class="material-icons">add</i> Add New Address
            </button>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary btn-confirm-default-address">Confirm</button>
            </div>
         </div>
      </div>
   </div>
</div>
 <!-- Form New Address Modal -->
 <div class="modal fade" id="formNewAddressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">New Address</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="modal-body">
            <form action="{{ route('customer.addNewAddress') }}" method="post" id="formCreateNewAddress">
               @csrf()
               <div class="card-content content-modal-new-address">

                  <div class="input-group">
                     <span class="input-group-addon">
                        <i class="material-icons">face</i>
                     </span>
                     <div class="form-group is-empty"><input type="text" name="full-name" class="form-control" placeholder="Full name..." id="input-full-name"><span class="material-input"></span></div>
                  </div>

                  <div class="input-group">
                     <span class="input-group-addon">
                        <i class="material-icons">phone</i>
                     </span>
                     <div class="form-group is-empty"><input type="text" name="phone-number" class="form-control" placeholder="Phone number..." id="input-phone-number"><span class="material-input"></span></div>
                  </div>

                  <div class="input-group">
                     <div class="form-group is-empty">
                        <div class="select-locations">
                           <p style="padding-left: 50px !important;">
                              City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District
                           </p>
                           <div class="select-city">
                              <select name="city" class="city">
                              </select>
                          </div>
                           <div class="select-district">
                              <select name="district" class="district">
                              </select>
                          </div>
                        </div>
                     </div>
                  </div>

                  <div class="input-group">
                     <span class="input-group-addon">
                        <i class="material-icons">traffic</i>
                     </span>
                     <div class="form-group is-empty"><input type="text" class="form-control" name="street" placeholder="Street Name, Building, House No." id="input-street"><span class="material-input"></span></div>
                  </div>

                  <div class="input-group">
                     <div class="form-group is-empty">
                        <div class="togglebutton" style="padding-left: 18px !important;">
				            	<label>
				                	<input type="checkbox" name="default" value="1" id="input-set-default-address"><span class="toggle"></span>
									Set as default
				            	</label>
				            </div>
                     </div>
                  </div>

                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary btn-close-form-add-new-address" data-dismiss="modal">Close</button>
                     <button class="btn btn-primary btn-complete-edit-address">Complete</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
 <!-- Form Edit Address Modal -->
 <div class="modal fade" id="modalEditAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Edit Address</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="modal-body">
            <form action="{{ route('customer.storeEditAddress') }}" method="post" id="formEditAddress">
               @csrf()
               <div class="card-content content-modal-edit-address">
                  <input type="hidden" name="id" id="id-edit-address">

                  <div class="input-group">
                     <span class="input-group-addon">
                        <i class="material-icons">face</i>
                     </span>
                     <div class="form-group is-empty"><input type="text" name="full-name" class="form-control" placeholder="Full name..." id="edit-full-name"><span class="material-input"></span></div>
                  </div>

                  <div class="input-group">
                     <span class="input-group-addon">
                        <i class="material-icons">phone</i>
                     </span>
                     <div class="form-group is-empty"><input type="text" name="phone-number" class="form-control" placeholder="Phone number..." id="edit-phone-number"><span class="material-input"></span></div>
                  </div>

                  <div class="input-group">
                     <div class="form-group is-empty">
                        <div class="select-locations">
                           <p style="padding-left: 50px !important;">
                              City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District
                           </p>
                           <div class="select-city">
                              <select name="city" class="edit-city">
                              </select>
                          </div>
                           <div class="select-district">
                              <select name="district" class="edit-district">
                              </select>
                          </div>
                        </div>
                     </div>
                  </div>

                  <div class="input-group">
                     <span class="input-group-addon">
                        <i class="material-icons">traffic</i>
                     </span>
                     <div class="form-group is-empty"><input type="text" class="form-control" name="street" placeholder="Street Name, Building, House No." id="edit-street"><span class="material-input"></span></div>
                  </div>

                  <div class="input-group">
                     <div class="form-group is-empty">
                        <div class="togglebutton" style="padding-left: 18px !important;">
				            	<label>
				                	<input type="checkbox" name="default" value="1" id="edit-set-default-address"><span class="toggle"></span>
									Set as default
				            	</label>
				            </div>
                     </div>
                  </div>

                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary btn-close-form-add-new-address" data-dismiss="modal">Close</button>
                     <button class="btn btn-primary btn-complete-edit-new-address">Complete</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
@push('js')
<script>
   async function loadDistrict(parent) {

      parent.find(".district, .edit-district").empty();
      
      var path = parent.find(".city option:selected, .edit-city option:selected").data('path');

      if (path === undefined) {
         path = '/data/SG.json';
      }

      const response    = await fetch('{{ asset('locations/') }}' + path);
      const districts   = await response.json();

      $.each(districts.district, function(index, each){
         $(".district, .edit-district").append(
         `<option>
               ${each.name}
         </option>`)
      })
   }

   async function myFunction() {

      const response = await fetch('{{ asset('locations/Index.json') }}');

      const cities   = await response.json();

      $.each(cities, function(index, each){
         $(".city, .edit-city").append(
         `<option value='${index}' data-path='/data/${each.code}.json'>
               ${index}
         </option>`)
      })

      $('.city option[value="Hồ Chí Minh"]').attr('selected',true);
   }

   $(document).ready(function () {

      $(".btn-add-new-address").click(function(e) {
         $("#addressModal").modal("hide");
      });

      $(".btn-close-form-add-new-address").click(function(e) {
         $("#addressModal").modal("show");
      });

      myFunction();
      
      $(".city, .edit-city").change(function() {
         loadDistrict($(this).parents('.select-locations'));
      });
      loadDistrict($(".city").parents('.select-locations'));

      $("#formCreateNewAddress").submit(function(e) {

         e.preventDefault();

         var form = $(this);
         var actionUrl = form.attr('action');
         var formData = new FormData(this);

         $.ajax({
            type: "POST",
            url: actionUrl,
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false, 
            success: function(data)
            {
               $.notify("Add new address successfully", "success");
               $("#formNewAddressModal").modal("hide");
               setTimeout(function(){
                  location.reload(); 
                }, 2000);
            },
            error: function (response) {
            },
         });
      });

      $(".a-edit-address").click(function(e) {

         $("#addressModal").modal("hide");

         const parents = $(this).parents('.tr-address-detail');

         var id = parents.find('.input-id').val();

         $.ajax({
            type: "POST",
            url: '{{route("customer.editAddress")}}',
            data:{'id': id},
            success: function(data)
            {
               $("#modalEditAddress").modal("show");

               var parents = $(".content-modal-edit-address");

               parents.find("#id-edit-address").val(data['id']);

               parents.find("#edit-full-name").val(data['full_name']);

               parents.find("#edit-phone-number").val(data['phone_number']);

               parents.find(".edit-city").val(data['city']);
               
               parents.find(".edit-district").val(data['district']);

               parents.find("#edit-street").val(data['street']);
               if(data['default'] === 1) {
                  parents.find("#edit-set-default-address").val(data['default']);
                  $("#edit-set-default-address").attr("checked", true);
               } else {
                  $("#edit-set-default-address").attr("checked", false);
               }
            },
            error: function (response) {
            },
         });   
      });

      $("#formEditAddress").submit(function(e) {

         e.preventDefault();

         var form = $(this);
         var actionUrl = form.attr('action');
         var formData = new FormData(this);

         $.ajax({
            type: "POST",
            url: actionUrl,
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false, 
            success: function(data)
            {
               $.notify("Add edit address successfully", "success");
               $("#modalEditAddress").modal("hide");
               setTimeout(function(){
                  location.reload(); 
               }, 2000);
            },
            error: function (response) {
            },
         });
      });

      $(".btn-confirm-default-address").click(function(e) {

         const parents = $(this).parents(".list-address");

         var id = parents.find(".radio-default-address:checked").val();

         $.ajax({
            type: "POST",
            url: '{{route("customer.confirmDefaultAddress")}}',
            data:{'id': id},
            success: function(data)
            {
               $.notify("set default address successfully", "success");

               $("#addressModal").modal("hide");

               setTimeout(function(){
                  location.reload(); 
               }, 2000);
               
            },
            error: function (response) {
            },
         }); 
      });
   });
</script>
@endpush