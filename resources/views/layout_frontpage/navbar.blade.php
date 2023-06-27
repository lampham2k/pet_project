@push('css')
<style>
   .main-raised {
      margin: -1px 30px 0px !important;
   }
</style>
@endpush
<nav class="navbar navbar-inverse navbar-fixed-top ">
    <div class="container">
       <!-- Brand and toggle get grouped for better mobile display -->
       <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
          <a class="pull-left" href="#pablo">
            <div class="avatar">
               <img class="media-object img-circle" src="{{ asset('image/vit.png') }}" alt="..." width="50px" height="50px">
            </div>
         </a>
       </div>
       <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
             <li>
                <a href="{{ route('customer.welcome') }}">
                  {{ __('frontpage.home') }}
                </a>
             </li>
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  {{ __('frontpage.products') }}
                <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-with-icons">
                   <li>
                      <a href="{{ route('customer.products', ['products' => 'all']) }}">
                        {{ __('frontpage.all_products') }}
                      </a>
                   </li>
                   <li>
                      <a href="{{ route('customer.products', ['products' => 'discounts']) }}">
                        {{ __('frontpage.products_are_on_sale') }}
                      </a>
                   </li>
                </ul>
             </li>
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  {{ __('frontpage.languages') }}
                <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-with-icons">
                   <li>
                     <a href="{{ route('language', 'en') }}">
                        <img src="{{ asset('image/us.svg') }}" alt="user-image" class="mr-1" height="12"> <span class="align-middle"> English</span>
                     </a>
                   </li>
                   <li>
                     <a href="{{ route('language', 'vi') }}">
                        <img src="{{ asset('image/vn.svg') }}" alt="user-image" class="mr-1" height="12"> <span class="align-middle"> Tiếng Việt</span>
                     </a>
                   </li>
                </ul>
             </li>
             <li>
               <a href="{{ route('customer.place-order') }}">
                  {{ __('frontpage.my_purchase') }}
               </a>
            </li>
             <li>
                <a href="{{ route('customer.carts') }}" class="btn btn-rose btn-raised btn-round">
                <i class="material-icons">shopping_cart</i> {{ __('frontpage.cart') }}
                </a>
             </li>
             <li class="li-form">
               <form class="navbar-form navbar-right" role="search" id="formSearchProduct" method="GET">
                  @csrf()
                  <div class="form-group form-white is-empty">
                    <input type="text" class="form-control" placeholder="Tìm kiếm" name="search" id="search">
                  <span class="material-input"></span></div>
                  <button class="btn btn-white btn-raised btn-fab btn-fab-mini"><i class="material-icons">search</i></button>
                </form>
             </li>
          </ul>
       </div>
    </div>
 </nav>
 @push('js')
<script>
    $(document).ready( function () {

      $("#search").change(function() {

         var search        = $(this).val();

         var actionUrl     = '{{ route('customer.products', ['products' => 'search']) }}';

         actionUrl         = actionUrl.replace('search', search);

         var form          = $(this).parents("#formSearchProduct");

         form.attr('action', actionUrl);

      });
    });
</script>
@endpush