@extends('layout_frontpage.master')
@push('css')
<style>
.section {
   padding: 29px 0 !important;   
}
</style>
@endpush
@section('content')
<div class="section"></div>
<div class="row">
    <div class="col-md-12">
       <h3 style="padding-left: 50px; !important;">Shopping / Cart</h3>
    </div>
    <div class="col-md-10 col-md-offset-1">
       <div class="table-responsive">
          <table class="table table-shopping">
             <thead>
                <tr>
                   <th></th>
                   <th class="text-center"></th>
                   <th>Product</th>update-quantity
                   <th class="th-description">Size</th>
                   <th class="text-right">Price</th>
                   <th class="text-right">Qty</th>
                   <th class="text-right">Amount</th>
                   <th></th>
                </tr>
             </thead>
             <tbody>
               <form action="{{ route('customer.checkout') }}" method="post">
               @csrf
                @foreach ($myCart as $idProducts => $eachValueProduct )
                  <tr>
                     <td>
                     <div class="checkbox">
                        <label>
                           <input type="checkbox" name="arrId[]" value="{{ $idProducts }}"><span class="checkbox-material"><span class="check"></span></span>
                        </label>
                     </div>
                     </td>
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
                        <div class="btn-group">
                           <button type="button" class="btn btn-info btn-xs btn-update-quantity" data-type='0' data-id="{{ $idProducts }}"> <i class="material-icons">remove</i> </button>
                           <button type="button" class="btn btn-info btn-xs btn-update-quantity" data-type='1' data-id="{{ $idProducts }}"> <i class="material-icons">add</i> </button>
                        </div>
                     </td>
                     <td class="td-number">
                     <p class= "p-amount" style="display: inline; !important;">{{ $eachValueProduct['amount'] }}</p><small>đ</small>
                     </td>
                     <td class="td-actions">
                        <button type="button" rel="tooltip" data-placement="left" title="" class="btn btn-simple" data-original-title="Remove item">
                        <i class="material-icons">close</i>
                        </button>
                     </td>
                  </tr>
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
                   <td colspan="3" class="text-right"> <button class="btn btn-info btn-round">Check out <i class="material-icons">keyboard_arrow_right</i></button></td>
                </tr>
               </form>
             </tbody>
          </table>
       </div>
    </div>
 </div>
@endsection
@push('js')
   <script>
        $(document).ready(function(){
         $(".btn-update-quantity").click(function(){ 

            let btn  = $(this);
            let type = parseInt(btn.data('type'));
            let id   = parseInt(btn.data('id'));

            $.ajax({
            type: "POST",
            url: "{{ route('customer.update-quantity') }}",
            data: {id: id, type: type},
            success: function (result) {
               let total         = 0;
               let parent_tr     = btn.parents('tr');
               let arrId         = [];
               let parent_tbody  = parent_tr.parents('tbody');
               let tr            = parent_tbody.find('.tr-total');

               if(Object.keys(result).length !== 0){
                  Object.entries(result).forEach(([idProduct, value]) => {

                     arrId.push(idProduct);

                     total += value['amount'];

                     if (idProduct == id) {

                        parent_tr.find('.p-quantity').text(value['quantity']);

                        parent_tr.find('.p-amount').text(value['amount']);

                     }
                  })

                  tr.find('.p-total').text(total);

               } else {

                  tr.find('.p-total').text(total);

               }

               let idToString = id.toString();

               if(!arrId.includes(idToString)){

                  parent_tr.remove();

               }
            }
         });
      });        
   });
   </script>
@endpush