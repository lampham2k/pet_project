@extends('layout_frontpage.master')
@section('content')
<div class="cd-section" id="headers">
    <div class="header-3">
       <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <div class="carousel slide" data-ride="carousel">
             <!-- Indicators -->
             <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
             </ol>
             <!-- Wrapper for slides -->
             <div class="carousel-inner">
                <div class="item active">
                   <div class="page-header header-filter" style="background-image: url('{{ asset('image/jd1.png') }}');">
                      <div class="container">
                         <div class="row">
                            <div class="col-md-6 text-left">
                               <h1 class="title">Jordan VI</h1>
                               <h4>The two met in Milan in 1980 and designed for the same fashion house.</h4>
                               <br />
                               <div class="buttons">
                                  <a href="#pablo" class="btn btn-primary btn-lg">
                                  Read More
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-white btn-simple btn-lg">
                                  <i class="fa fa-twitter"></i>
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-white btn-simple btn-lg">
                                  <i class="fa fa-facebook-square"></i>
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-white btn-simple btn-lg">
                                  <i class="fa fa-get-pocket"></i>
                                  </a>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="item">
                   <div class="page-header header-filter" style="background-image: url('{{ asset('image/jd2.png') }}');">
                      <div class="container">
                         <div class="row">
                            <div class="col-md-8 col-md-offset-2 text-center">
                               <h1 class="title">Jordan XII</h1>
                               <h4>The two met in Milan in 1980 and designed for the same fashion house.</h4>
                               <br />
                               <h6>Connect with us on:</h6>
                               <div class="buttons">
                                  <a href="#pablo" class="btn btn-just-icon btn-white btn-simple btn-lg">
                                  <i class="fa fa-twitter"></i>
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-white btn-simple btn-lg">
                                  <i class="fa fa-facebook-square"></i>
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-white btn-simple btn-lg">
                                  <i class="fa fa-google-plus"></i>
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-white btn-simple btn-lg">
                                  <i class="fa fa-instagram"></i>
                                  </a>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="item">
                   <div class="page-header header-filter" style="background-image: url('{{ asset('image/jd3.png') }}');">
                      <div class="container">
                         <div class="row">
                            <div class="col-md-7 col-md-offset-5 text-right">
                               <h1 class="title">Jordan XV 50% Off</h1>
                               <h4>There's no doubt that Tesla is delighted with the interest</h4>
                               <br />
                               <div class="buttons">
                                  <a href="#pablo" class="btn btn-white btn-simple btn-lg">
                                  <i class="material-icons">share</i> Share Offer
                                  </a>
                                  <a href="#pablo" class="btn btn-danger btn-lg">
                                  <i class="material-icons">shopping_cart</i> Shop Now
                                  </a>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
             <!-- Controls -->
             <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
             <i class="material-icons">keyboard_arrow_left</i>
             </a>
             <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
             <i class="material-icons">keyboard_arrow_right</i>
             </a>
          </div>
       </div>
    </div>
    <!--     *********    END HEADER 3      *********      -->
 </div>
<div class="section">
    {{-- Sale --}}
    <div class="container">
        <h2 class="section-title">Sale</h2>
        <div class="row">
             <div class="col-md-4">
                 <div class="card card-product card-plain">
                     <div class="card-image">
                         <a href="#pablo">
                             <img src="{{ asset('image/nike1.webp') }}" alt="">
                         </a>
                     <div class="colored-shadow" style="background-image: url(&quot;../assets/img/examples/gucci.jpg&quot;); opacity: 1;"></div><div class="ripple-container"></div></div>
                     <div class="card-content">
                         <h4 class="card-title">
                             <a href="#pablo">Gucci</a>
                         </h4>
                         <p class="card-description">The structured shoulders and sleek detailing ensure a sharp silhouette. Team it with a silk pocket square and leather loafers.</p>
                         <div class="footer">
                             <div class="price-container">
                                 <span class="price price-old"> €1,430</span>
                                    <span class="price price-new"> €743</span>
                             </div>
                             <div class="stats">
                                 <button type="button" rel="tooltip" title="" class="btn btn-just-icon btn-simple btn-rose" data-original-title="Saved to Wishlist">
                                     <i class="material-icons">favorite</i>
                                 </button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-md-4">
                 <div class="card card-product card-plain">
                     <div class="card-image">
                         <a href="#pablo">
                             <img src="{{ asset('image/nike2.webp') }}" alt="">
                         </a>
                     <div class="colored-shadow" style="background-image: url(&quot;../assets/img/examples/dolce.jpg&quot;); opacity: 1;"></div><div class="ripple-container"></div></div>

                     <div class="card-content">
                         <h4 class="card-title">
                             </h4><h4 class="card-title">Dolce &amp; Gabbana</h4>
                         
                         <p class="card-description">The structured shoulders and sleek detailing ensure a sharp silhouette. Team it with a silk pocket square and leather loafers.</p>
                         <div class="footer">
                             <div class="price-container">
                                 <span class="price price-old"> €1,430</span>
                                    <span class="price price-new">€743</span>
                             </div>
                             <div class="stats">
                                 <button type="button" rel="tooltip" title="" class="btn btn-just-icon btn-simple btn-rose" data-original-title="Saved to Wishlist">
                                      <i class="material-icons">favorite</i>
                                  </button>
                             </div>
                         </div>
                     </div>
                 </div>

             </div>

             <div class="col-md-4">

                 <div class="card card-product card-plain">
                     <div class="card-image">
                         <a href="#pablo">
                             <img src="{{ asset('image/nike3.webp') }}" alt="">
                         </a>
                     <div class="colored-shadow" style="background-image: url(&quot;../assets/img/examples/tom-ford.jpg&quot;); opacity: 1;"></div></div>

                     <div class="card-content">
                         <h4 class="card-title">
                             </h4><h4 class="card-title">Dolce &amp; Gabbana</h4>
                         
                         <p class="card-description">The structured shoulders and sleek detailing ensure a sharp silhouette. Team it with a silk pocket square and leather loafers.</p>
                         <div class="footer">
                             <div class="price-container">
                                 <span class="price price-old"> €1,430</span>
                                    <span class="price price-new">€743</span>
                             </div>
                             <div class="stats">
                                 <button type="button" rel="tooltip" title="" class="btn btn-just-icon btn-simple btn-rose" data-original-title="Saved to Wishlist">
                                      <i class="material-icons">favorite</i>
                                  </button>
                             </div>
                         </div>
                     </div>
                 </div>

             </div>

        </div>
    </div>
    {{-- Best sale --}}
    <div class="container">
        <h2 class="section-title">Best Sale</h2>
        <div class="row">
             <div class="col-md-4">
                 <div class="card card-product card-plain">
                     <div class="card-image">
                         <a href="#pablo">
                             <img src="{{ asset('image/nike6.jpeg') }}" alt="">
                         </a>
                     <div class="colored-shadow" style="background-image: url(&quot;../assets/img/examples/gucci.jpg&quot;); opacity: 1;"></div><div class="ripple-container"></div></div>
                     <div class="card-content">
                         <h4 class="card-title">
                             <a href="#pablo">Gucci</a>
                         </h4>
                         <p class="card-description">The structured shoulders and sleek detailing ensure a sharp silhouette. Team it with a silk pocket square and leather loafers.</p>
                         <div class="footer">
                             <div class="price-container">
                                    <span class="price price-new"> €743</span>
                             </div>
                             <div class="stats">
                                 <button type="button" rel="tooltip" title="" class="btn btn-just-icon btn-simple btn-rose" data-original-title="Saved to Wishlist">
                                     <i class="material-icons">favorite</i>
                                 </button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-md-4">
                 <div class="card card-product card-plain">
                     <div class="card-image">
                         <a href="#pablo">
                             <img src="{{ asset('image/nike7.jpeg') }}" alt="">
                         </a>
                     <div class="colored-shadow" style="background-image: url(&quot;../assets/img/examples/dolce.jpg&quot;); opacity: 1;"></div><div class="ripple-container"></div></div>

                     <div class="card-content">
                         <h4 class="card-title">
                             </h4><h4 class="card-title">Dolce &amp; Gabbana</h4>
                         
                         <p class="card-description">The structured shoulders and sleek detailing ensure a sharp silhouette. Team it with a silk pocket square and leather loafers.</p>
                         <div class="footer">
                             <div class="price-container">
                                    <span class="price price-new">€743</span>
                             </div>
                             <div class="stats">
                                 <button type="button" rel="tooltip" title="" class="btn btn-just-icon btn-simple btn-rose" data-original-title="Saved to Wishlist">
                                      <i class="material-icons">favorite</i>
                                  </button>
                             </div>
                         </div>
                     </div>
                 </div>

             </div>

             <div class="col-md-4">

                 <div class="card card-product card-plain">
                     <div class="card-image">
                         <a href="#pablo">
                             <img src="{{ asset('image/nike8.jpeg') }}" alt="">
                         </a>
                     <div class="colored-shadow" style="background-image: url(&quot;../assets/img/examples/tom-ford.jpg&quot;); opacity: 1;"></div></div>

                     <div class="card-content">
                         <h4 class="card-title">
                             </h4><h4 class="card-title">Dolce &amp; Gabbana</h4>
                         
                         <p class="card-description">The structured shoulders and sleek detailing ensure a sharp silhouette. Team it with a silk pocket square and leather loafers.</p>
                         <div class="footer">
                             <div class="price-container">
                                    <span class="price price-new">€743</span>
                             </div>
                             <div class="stats">
                                 <button type="button" rel="tooltip" title="" class="btn btn-just-icon btn-simple btn-rose" data-original-title="Saved to Wishlist">
                                      <i class="material-icons">favorite</i>
                                  </button>
                             </div>
                         </div>
                     </div>
                 </div>

             </div>

        </div>
    </div>
</div>
@endsection