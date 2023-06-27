@push('css')
<style>
.div-product-to-pay {
    padding: 39px 0;
}

.main-raised {
    margin: -66px 210px 0px !important;
}

.div-product-to-pay-detail {
    padding-left: 57px !important;
}

</style>
@endpush
<div class="section">
    @include('layout_frontpage.nav_myPurchase')
</div>
@extends('layout_frontpage.master')
@section('content')
@foreach ( $myArrProductToPay as $orderId => $products )
    @foreach ( $products as $idProduct => $each )
        @if ($each['status'] == 0)
        <div class="section div-product-to-pay">
            <div class="main main-raised main-product">
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                    <div class="tab-content">
                            <div class="tab-pane active" id="product-page2">
                                <img src="{{ asset("storage/product_photo/".$each['photo_product']) }}" style="width:200px !important; height:303px !important;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-7 div-product-to-pay-detail">
                        <input type="hidden" value="{{ $orderId }}" class="order-id">
                        <input type="hidden" value="{{ $idProduct }}" class="id-product-to-pay">
                        <h4 class="title"> {{ $each['name_product'] }} </h4>
                        <h5 class="main-price">size {{ $each['size'] }}</h3>
                        <h5 class="main-price">{{ $each['price'] }} VND</h3>
                        <h5 class="main-price">x{{ $each['quantity'] }}</h3>
                        <h5 class="main-price ">Amount Payable:<div class="text-danger">{{ $each['amount'] }}đ</div></h3>
                        <div class="row text-right">
                            <button type="button" class="btn btn-rose btn-round btn-cancel">Cancel &nbsp;<i class="material-icons">cancel</i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
@endforeach
@endsection
@push('js')
<script>
    $(document).ready( function () {

        $(".btn-cancel").click(function(e) { 

            const parents       = $(this).parents(".div-product-to-pay-detail");
            
            var productIdCancel = parents.find(".id-product-to-pay").val();

            var orderId         = parents.find(".order-id").val();

            $.ajax({
                type: "POST",
                url: '{{route("customer.cancelProduct")}}',
                data:{'productIdCancel': productIdCancel, 'orderId': orderId},

                success: function(data)
                {
                    $.notify("cancel product successfully", "success");
                    setTimeout(function(){
                        location.reload(); 
                    }, 1000);
                },
                error: function (response) {
                },
         }); 

        });
    });
</script>
@endpush