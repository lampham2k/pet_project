@extends('layout_frontpage.master')
@push('css')
<style>
    * {
  font-family: 'Oswald', sans-serif;
}
.section {
    padding: 30px 0;
}
.f {
    padding: 1px 0;
}
.containerr {
  margin: 30px;
  width: 80%;
  justify-content: center;
  flex-direction: column;
  align-items: center;
}
h5 {
  text-transform: uppercase;
  margin: 0;
  font-size: 14px;
}
ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
a {
  text-decoration: none;
  color: #bbb;
}
.product-image {
  display: flex;
  flex-direction: column;
  align-items: center;
  background: linear-gradient(to bottom, #6bffc8 0%, #42c8cb 100%);
  border-radius: 20px 20px 0 0;
  padding: 55px 0;
  width: 100%;
  margin: auto;
}
.product-pic {
  max-width: 180px;
  position: relative;
  left: 0;
  margin: 40px 0;
  filter: drop-shadow(-6px 40px 23px rgba(0, 0, 0, 0.5));
}
.product-details {
  padding: 40px;
  background-color: white;
  border-radius: 0 0 20px 20px;
}
.product-details .title {
  text-transform: uppercase;
  margin: 0;
}
.product-details .colorCat {
  text-transform: uppercase;
  font-style: italic;
  color: #bbb;
  font-weight: 700;
  font-size: 14px;
}
.product-details .price {
  font-weight: 700;
  margin-top: 5px;
  font-size: 18px;
}
.product-details .price .current {
  color: #fe6168;
  margin-left: 6px;
}
.product-details .before {
  text-decoration: line-through;
}
.product-details header {
  margin-bottom: 50px;
  position: relative;
}
.product-details article > h5 {
  margin: 0;
}
.product-details article > p {
  color: #bbb;
  margin: 0.5em 0;
  font-size: 14px;
  line-height: 1.6;
}
.product-details .controls {
  margin: 3em 0;
}
.product-details .controls > div {
  flex: 1;
}
.product-details .controls .option {
  margin-top: 12px;
  display: inline-block;
  position: relative;
}
.product-details .controls .option:hover {
  color: #444444;
}
.product-details .controls .option::before {
  content: '';
  position: absolute;
  border-width: 2px 2px 0 0;
  border-style: solid;
  top: 0;
  bottom: 0;
  height: 5px;
  width: 5px;
  right: -18px;
  margin: auto;
  transform: rotate(135deg);
}
.product-details .controls > div + div {
  margin-top: 20px;
  flex: none;
}
.product-details .controls ul {
  display: flex;
  margin: 15px 5px;
}
.product-details .color li + li {
  margin-left: 15px;
}
.product-details .colors {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  display: block;
}
.product-details .color-bdot1 {
  background-color: #59e8c8;
}
.product-details .color-bdot1:hover, .product-details .color-bdot1.active {
  box-shadow: 0 0 0 3px white, 0 0 0 5px #59e8c8;
}
.product-details .color-bdot2 {
  background-color: #ffee71;
}
.product-details .color-bdot2:hover, .product-details .color-bdot2.active {
  box-shadow: 0 0 0 3px white, 0 0 0 5px #ffee71;
}
.product-details .color-bdot3 {
  background-color: #6654af;
}
.product-details .color-bdot3:hover, .product-details .color-bdot3.active {
  box-shadow: 0 0 0 3px white, 0 0 0 5px #6654af;
}
.product-details .color-bdot4 {
  background-color: #343434;
}
.product-details .color-bdot4:hover, .product-details .color-bdot4.active {
  box-shadow: 0 0 0 3px white, 0 0 0 5px #343434;
}
.product-details .color-bdot5 {
  background-color: #dfdfdf;
}
.product-details .color-bdot5:hover, .product-details .color-bdot5.active {
  box-shadow: 0 0 0 3px white, 0 0 0 5px #dfdfdf;
}
.product-details .rate {
  position: static;
  margin-top: 10px;
}
.product-details .rate a {
  font-size: 18px;
  color: #bbb;
}
.product-details .rate a.active, .product-details .rate a:hover {
  color: #fe6067;
}
.dots {
  display: flex;
  margin-top: 40px;
}
.dots > a {
  background-color: #349a98;
  width: 10px;
  height: 10px;
  margin: 0 4px;
  border-radius: 50%;
}
.dots > a:hover, .dots > a.active {
  background-color: white;
}
.dots i {
  display: none;
}
.footerr {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.footerr > button {
  display: flex;
  border: 0;
  padding: 15px 25px;
  align-items: center;
  border-radius: 7px;
  cursor: pointer;
  background: linear-gradient(to bottom, #ff886b 0%, #ff4164 100%);
  box-shadow: 0 10px 30px 0 rgba(255, 136, 107, 0.7);
  transition: 200ms;
}
.footerr > button:hover {
  background: linear-gradient(to bottom, #ff4164 0%, #ff886b 100%);
}
.footerr > button > img {
  width: 31px;
}
.footerr > button > span {
  font-size: 18px;
  text-transform: uppercase;
  font-weight: 700;
  margin-left: 10px;
  color: white;
}
.footerr > a img {
  width: 24px;
  opacity: 0.8;
}
.footerr > a:hover img {
  opacity: 1;
}
@media (min-width: 37.5em) {
  .product-details .rate {
    position: absolute;
    top: 12px;
    right: 10px;
    margin-top: 0;
  }
  .product-details .controls > div.qty {
    width: 60px;
  }
  .product-details .controls > div + div {
    border-left: 2px solid rgba(187, 187, 187, 0.5);
    padding-left: 25px;
    padding-right: 25px;
    width: 100px;
    margin-top: 0;
  }
  .product-details .controls {
    display: flex;
  }
}
@media (min-width: 56.25em) {
  .containerr {
    display: flex;
    flex-direction: row;
    align-items: normal;
    margin: auto;
  }
  .product-image {
    border-radius: 20px 0 0 20px;
    max-width: 330px;
  }
  .product-pic {
    left: -40px;
    max-width: 330px;
  }
  .product-details {
    width: 100%;
    border-radius: 0 20px 20px 0;
  }
}

</style>
@endpush
@section('content')
<div class="section"></div>
<div class="containerr">
    <div class="product-image">
       <img src="{{ asset("storage/product_photo/".$data->photo) }}" alt="" class="product-pic">
       <div class="dots">
          <a href="#!" class="active"><i>1</i></a>
          <a href="#!"><i>2</i></a>
          <a href="#!"><i>3</i></a>
          <a href="#!"><i>4</i></a>
       </div>
    </div>
    <div class="product-details">
      <form id="formAddToCard" method="post" action="{{ route('customer.addToCards') }}">
        @csrf
        <input type="hidden" name="name" value="{{ $data->name }}">
       <header>
          <h1 class="title">{{ $data->name }}</h1>
          <span class="colorCat">{{ $data->type->name }}</span>
          @if (isset($data->max_discount_percent) or isset($data->max_discount_money))
          <div class="price">
             <span class="before">{{ $data->price }} đ</span>
             <span class="current">{{ $data->price_new }} đ</span>
          </div>
          @else
            <span class="before">{{ $data->price }} đ</span>
          @endif
          <div class="rate">
             <a href="#!" class="active">★</a>
             <a href="#!" class="active">★</a>
             <a href="#!" class="active">★</a>
             <a href="#!">★</a>
             <a href="#!">★</a>
          </div>
       </header>
       <article>
          <h5>{{ __('frontpage.Description') }}</h5>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
       </article>
       <div class="controls">
          <div class="color">
             <h5>color</h5>
             <ul>
                <li><a href="#!" class="colors color-bdot1 active"></a></li>
                <li><a href="#!" class="colors color-bdot2"></a></li>
                <li><a href="#!" class="colors color-bdot3"></a></li>
                <li><a href="#!" class="colors color-bdot4"></a></li>
                <li><a href="#!" class="colors color-bdot5"></a></li>
             </ul>
            <br>
            <div class="quantity">
              <h5>Số Lượng</h5>
              <button type="button" class="btn-update-quantity" data-type='0'> - </button>
              <input type="text" name="quantity" style="width:30px !important;" value="1" class="input-quantity">
              <button type="button" class="btn-update-quantity" data-type='1'> + </button>
            </div>
          </div>
          <div class="size">
             <h5>size</h5>
             <select name="size_id" id="">
              @foreach ($datas as $each )
                <option value="{{ $each->size->id }}" class="option" >{{ $each->size->size }}</option>
              @endforeach
             </select>
          </div>
          {{-- <div class="qty">
             <h5>qty</h5>
             <a href="#!" class="option" >(1)</a>
          </div> --}}
       </div>
       <div class="footerr">
          <button>
          <img src="http://co0kie.github.io/codepen/nike-product-page/cart.png" alt="">
          <span>add to cart</span>
          </button>
          <a href="#!"><img src="http://co0kie.github.io/codepen/nike-product-page/share.png" alt=""></a>
       </div>
      </form>
    </div>
 </div>
 <div class="section f"></div>
 <div class="section">
  <div id="comments">
     <div class="row">
        <div class="col-md-8 col-md-offset-2">
           <div class="media-area">
              <h3 class="title text-center">{{ $totalComment }} Comments</h3>
              <div class="all-comment">

                @php
                    $arr = [];
                @endphp

                @foreach ( $comments as $each )

                @if (!in_array($each->id, $arr))
                <div class="media">
                   <a class="pull-left" href="#pablo">
                      <div class="avatar">
                        @if (isset($each->user_photo))
                        <img class="media-object" alt="64x64" src="{{ asset('storage/user_avatar/'. $each->user_photo) }}">
                      @else
                        <img class="media-object" alt="64x64" src="https://toigingiuvedep.vn/wp-content/uploads/2022/02/anh-vit-vang-cute-cho-dien-thoai-vit-vang-nguoc-nhin-2.png">
                      @endif
                      </div>
                   </a>
                   <div class="media-body">
                      <h4 class="media-heading">{{ $each->user_name }}<small>· {{ $each->comment_time }}</small></h4>
                      <h6 class="text-muted"></h6>
                      <p>{{ $each->comment }}</p>
                      {{-- <div class="media-footer"> --}}
                         {{-- <a href="#pablo" class="btn btn-primary btn-simple pull-right" rel="tooltip" title="" data-original-title="Reply to Comment">
                         <i class="material-icons">reply</i> Reply
                         </a> --}}
                         {{-- <a href="#pablo" class="btn btn-danger btn-simple pull-right">
                         <i class="material-icons">favorite</i> 243
                         </a> --}}
                      {{-- </div> --}}
                      @foreach ($comments as $value )
                        @if ($value->id == $each->id)
                          @if (isset($value->user_reply_comment))
                          <div class="media">
                            <a class="pull-left" href="#pablo">
                              <div class="avatar">
                                @if (isset($value->user_photo_reply))
                                  <img class="media-object" alt="64x64" src="{{ asset('storage/user_avatar/'. $value->user_photo) }}">
                                @else
                                  <img class="media-object" alt="64x64" src="https://toigingiuvedep.vn/wp-content/uploads/2022/02/anh-vit-vang-cute-cho-dien-thoai-vit-vang-nguoc-nhin-2.png">
                                @endif
                              </div>
                            </a>
                            <div class="media-body">
                              <h4 class="media-heading">{{ $value->user_name_reply }} <small>· {{ $value->comment_reply_time }}</small></h4>

                              <p>{{ $value->user_reply_comment }}</p>
                            </div>
                          </div>
                          @endif
                        @endif
                      @endforeach
                      @if (isOwner())
                      <div class="media-reply">
                        <div class="media">
                           <a class="pull-left author" href="#pablo">
                              <div class="avatar">
                                @if (isset($avatar))
                                  <img class="media-object" alt="64x64" src="{{ asset('storage/user_avatar/'. $avatar) }}">
                                @else
                                  <img class="media-object" alt="64x64" src="https://toigingiuvedep.vn/wp-content/uploads/2022/02/anh-vit-vang-cute-cho-dien-thoai-vit-vang-nguoc-nhin-2.png">
                                @endif
                              </div>
                           </a>
                           <form action="{{ route('customer.reply-comment') }}" method="POST" id="formReplyComment">
                            @csrf()
                            <input type="hidden" value="{{ $each->id }}" name="users_comment_product_id">
                             <div class="media-body">
                                <div class="form-group is-empty"><textarea class="form-control" placeholder="your comment" rows="4" name="comment"></textarea><span class="material-input"></span></div>
                                <div class="media-footer">
                                   <button class="btn btn-primary pull-right">
                                    <i class="material-icons">reply</i> Reply
                                   </button>
                                </div>
                             </div>
                           </form>
                        </div>
                      </div>
                      @endif
                   </div>
                </div>

                @php
                  $arr[] = $each->id;
                @endphp
                @endif
                @endforeach
              </div>
              <div class="pagination-area text-center">
                 <ul class="pagination">
                    {{ $comments->links() }}
                 </ul>
              </div>
           </div>
           @if ($allow == true)
           <div class="post-your-comment">
             <h3 class="text-center">Post your comment <br></h3>
             <div class="media media-post">
                <a class="pull-left author" href="#pablo">
                   <div class="avatar">
                      @if (isset($avatar))
                        <img class="media-object" alt="64x64" src="{{ asset('storage/user_avatar/'.$avatar) }}">
                      @else
                        <img class="media-object" alt="64x64" src="https://toigingiuvedep.vn/wp-content/uploads/2022/02/anh-vit-vang-cute-cho-dien-thoai-vit-vang-nguoc-nhin-2.png">
                      @endif
                    </div>
                </a>
                <form action="{{ route('customer.post-comment') }}" method="POST" id="formPostComment">
                   @csrf()
                   <input type="hidden" name="product_name" value="{{ $data->name }}">
                   <div class="media-body">
                      <div class="form-group is-empty">
                         <textarea name="comment" class="form-control" placeholder="Write your comment" rows="6"></textarea>
                         <span class="material-input"></span>
                      </div>
                      <div class="media-footer">
                         <button class="btn btn-primary btn-wd pull-right post-comment">Post Comment</button>
                      </div>
                   </div>
                </form>
             </div>
           </div>
           @endif
        </div>
     </div>
  </div>
</div>
@endsection
@push('js')
<script>
  $(document).ready(function(){
    $(".btn-update-quantity").click(function(){ 
      let btn = $(this);
      let type = parseInt(btn.data('type'));

      let parents = btn.parents('.quantity');
      let quantity = parseInt(parents.find(".input-quantity").val());
      if(type == 0){
        if(quantity == 1){
          preventDefault();
        }
        quantity--;
        $(".input-quantity").val(quantity);
      } else {
        quantity++;
        $(".input-quantity").val(quantity);
      }
      // parents.find('.span-quantity').text(quantity);
  });

    $("#formAddToCard").submit(function(e) { 
      e.preventDefault();

      var allInputs = $(".input-quantity").val();
      var regex     = new RegExp("[0-9]+");
      if (regex.test(allInputs)) {

        var form      = $(this);

        var actionUrl = form.attr('action');

        var formData  = new FormData(this);

        $.ajax({
            type: "POST",
            url: actionUrl,
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false, 
            success: function(data)
            {
              $.notify("Add to cart successfully", "success");
            },
            error: function (response) {
            },
        });
      } else {
        alert('Please enter a valid quantity.');
      }
  });

    $("#formPostComment").submit(function(e) { 

      e.preventDefault();

      var form      = $(this);

      var actionUrl = form.attr('action');

      var formData  = new FormData(this);

        $.ajax({
            type: "POST",
            url: actionUrl,
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false, 
            success: function(data)
            {
              $.notify("you have commented successfully", "success");

              $.each(data.data, function(index, each){

                $(".all-comment").append(
                    `
                    <div class="media">
                      <a class="pull-left" href="#pablo">
                          <div class="avatar">
                            <img class="media-object" src="{{ asset('storage/user_avatar/') }}/${each['user_avatar']}" alt="avatar_user">
                          </div>
                      </a>
                      <div class="media-body">
                          <h4 class="media-heading">${each['user_name']} <small>· recently</small></h4>
                          <h6 class="text-muted"></h6>
                          <p>${each['comment']}</p>
                          <div class="media-footer">
                            <a href="#pablo" class="btn btn-primary btn-simple pull-right" rel="tooltip" title="" data-original-title="Reply to Comment">
                            <i class="material-icons">reply</i> Reply
                            </a>
                          </div>
                      </div>
                    </div>
                `)

                if (each['user_customer_role'] != 7) {
                  $(".post-your-comment").empty();
                }
              })
            },
            error: function (response) {
            },
        });
    });
    $("#formReplyComment").submit(function(e) { 

      e.preventDefault();

      var form      = $(this);

      var actionUrl = form.attr('action');

      var formData  = new FormData(this);

      var parents    = $(this).parents(".media-reply");
      console.log(parents);

        $.ajax({
            type: "POST",
            url: actionUrl,
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false, 
            success: function(data)
            {
              $.notify("you have reply commented successfully", "success");

              $.each(data.data, function(index, each){
                parents.append(`
                <div class="media">
                    <a class="pull-left" href="#pablo">
                      <div class="avatar">
                        <img class="media-object" alt="64x64" src="{{ asset('storage/user_avatar/') }}/${each['user_avatar']}">
                      </div>
                    </a>
                    <div class="media-body">
                      <h4 class="media-heading">${each['user_name']}<small>· recently</small></h4>
  
                      <p>${each['comment']}.</p>
                    </div>
                  </div>
                `)
              }); 
            },
            error: function (response) {
            },
        });
    });
});
</script>
@endpush