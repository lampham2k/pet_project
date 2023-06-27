<div class="sidebar" data-active-color="rose" data-background-color="black">
    <div class="logo">
       <a href="http://www.creative-tim.com" class="simple-text logo-mini">
       CT
       </a>
       <a href="http://www.creative-tim.com" class="simple-text logo-normal">
       Creative Tim
       </a>
    </div>
    <div class="sidebar-wrapper">
       <div class="user">
          <div class="photo">
             <img src="{{ asset('image/avatar.jpeg') }}" />
          </div>
          <div class="info">
             <a data-toggle="collapse" href="#collapseExample" class="collapsed">
             <span>
             Tania Andrew
             <b class="caret"></b>
             </span>
             </a>
             <div class="clearfix"></div>
             <div class="collapse" id="collapseExample">
                <ul class="nav">
                   <li>
                      <a href="#">
                      <span class="sidebar-mini"> MP </span>
                      <span class="sidebar-normal"> My Profile </span>
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      <span class="sidebar-mini"> EP </span>
                      <span class="sidebar-normal"> Edit Profile </span>
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      <span class="sidebar-mini"> S </span>
                      <span class="sidebar-normal"> Settings </span>
                      </a>
                   </li>
                </ul>
             </div>
          </div>
       </div>
          <ul class="nav">
            @if (isSuperAdmin())
               <li @if (URL::current() == route('admin.manufacturers.index'))
                  class="active"
               @endif>
                  <a href="{{ route('admin.manufacturers.index') }}">
                     <i class="material-icons">factory</i>
                     <p> Manufacturers </p>
                  </a>
               </li>
            @endif
             <li @if (URL::current() == route('admin.products.index'))
               class="active"
             @endif>
                <a href="{{ route('admin.products.index') }}">
                   <i class="material-icons">trolley</i>
                   <p> Products </p>
                </a>
             </li>
             @if (isSuperAdmin())
             <li @if (URL::current() == route('admin.users.index'))
               class="active"
             @endif>
                <a href="{{ route('admin.users.index') }}">
                   <i class="material-icons">person</i>
                   <p> Users </p>
                </a>
             </li>
             <li @if (URL::current() == route('admin.collaborators.index'))
               class="active"
             @endif>
                <a href="{{ route('admin.collaborators.index') }}">
                   <i class="material-icons">groups</i>
                   <p> Collaborators </p>
                </a>
             </li>
             <li @if (URL::current() == route('admin.discounts.index'))
               class="active"
             @endif>
                <a href="{{ route('admin.discounts.index') }}">
                   <i class="material-icons">groups</i>
                   <p> Discounts </p>
                </a>
             </li>
             <li @if (URL::current() == route('admin.orders.index'))
               class="active"
            @endif>
              <a href="{{ route('admin.orders.index') }}">
                 <i class="material-icons">groups</i>
                 <p> Orders </p>
              </a>
           </li>
             @endif
             {{-- <li>
                <a data-toggle="collapse" href="#pagesExamples">
                   <i class="material-icons">image</i>
                   <p> Pages
                      <b class="caret"></b>
                   </p>
                </a>
                <div class="collapse" id="pagesExamples">
                   <ul class="nav">
                      <li>
                         <a href="./pages/pricing.html">
                         <span class="sidebar-mini"> P </span>
                         <span class="sidebar-normal"> Pricing </span>
                         </a>
                      </li>
                      <li>
                         <a href="./pages/rtl.html">
                         <span class="sidebar-mini"> RS </span>
                         <span class="sidebar-normal"> RTL Support </span>
                         </a>
                      </li>
                      <li>
                         <a href="./pages/timeline.html">
                         <span class="sidebar-mini"> T </span>
                         <span class="sidebar-normal"> Timeline </span>
                         </a>
                      </li>
                      <li>
                         <a href="./pages/login.html">
                         <span class="sidebar-mini"> LP </span>
                         <span class="sidebar-normal"> Login Page </span>
                         </a>
                      </li>
                      <li>
                         <a href="./pages/register.html">
                         <span class="sidebar-mini"> RP </span>
                         <span class="sidebar-normal"> Register Page </span>
                         </a>
                      </li>
                      <li>
                         <a href="./pages/lock.html">
                         <span class="sidebar-mini"> LSP </span>
                         <span class="sidebar-normal"> Lock Screen Page </span>
                         </a>
                      </li>
                      <li>
                         <a href="./pages/user.html">
                         <span class="sidebar-mini"> UP </span>
                         <span class="sidebar-normal"> User Profile </span>
                         </a>
                      </li>
                   </ul>
                </div>
             </li> --}}
             <li  @if (URL::current() == route('admin.chart.index'))
             class="active"
          @endif>
                <a href="{{ route('admin.chart.index') }}">
                   <i class="material-icons">timeline</i>
                   <p> Charts </p>
                </a>
             </li>
          </ul>
    </div>
 </div>