{{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
{{ config('app.name', 'Laravel') }}
</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">

    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        @if (Route::has('register'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
        @endif
        @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        @endguest
    </ul>
</div>
</div>
</nav> --}}

<header id="wn__header" class="oth-page header__area header__absolute sticky__header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-7 col-lg-2">
                <div class="logo">
                    <a href="{{ route('frontend.index') }}">
                        <img src="{{ asset('front-assets/images/logo/logo.png') }}" alt="logo images">
                    </a>
                </div>
            </div>
            <div class="col-lg-8 d-none d-lg-block">
                <nav class="mainmenu__nav">
                    <ul class="meninmenu d-flex justify-content-start">
                        <li class="drop with--one--item"><a href="{{ route('frontend.index') }}">Home</a></li>
                        <li class="drop with--one--item"><a href="{{ route('post.show',['about-us']) }}">About</a></li>
                        <li class="drop with--one--item"><a href="{{ route('post.show',['our-vision']) }}">Our
                                Vision</a></li>

                        <li class="drop"><a href="javascript:void(0);">Blog</a>
                            <div class="megamenu dropdown">
                                <ul class="item item01">
                                    @foreach ($recent_categoreis as $recent_category)

                                    <li><a
                                            href="{{ route('category.posts',$recent_category->slug) }}">{{ $recent_category->name }}</a>
                                    </li>

                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{ route('front.contact') }}">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-8 col-sm-8 col-5 col-lg-2">
                <ul class="header__sidebar__right d-flex justify-content-end align-items-center">
                    <li class="shop_search"><a class="search__active" href="#"></a></li>
                    {{-- <li class="wishlist"><a href="#"></a></li> --}}
                    <li class="shopcart"><a class="cartbox_active" href="#"><span class="product_qun">3</span></a>
                        <!-- Start Shopping Cart -->
                        <div class="block-minicart minicart__active">
                            <div class="minicart-content-wrapper">

                                <div class="single__items">
                                    <div class="miniproduct">
                                        <div class="item01 d-flex">
                                            <div class="thumb">
                                                <a href="product-details.html"><img width="50" height="50"
                                                        src="{{ asset('front-end/posts/default-small.jpg') }}"
                                                        alt="product images"></a>
                                            </div>
                                            <div class="content">
                                                <h6><a href="product-details.html">You have new Comment on post</a></h6>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Shopping Cart -->
                    </li>
                    <li class="setting__bar__icon"><a class="setting__active" href="#"></a>
                        <div class="searchbar__content setting__block">
                            <div class="content-inner">

                                <div class="switcher-currency">
                                    <strong class="label switcher-label">
                                        <span>My Account</span>
                                    </strong>
                                    <div class="switcher-options">
                                        <div class="switcher-currency-trigger">
                                            <div class="setting__menu">

                                                @guest
                                                <span>
                                                    <a href="{{ route('front.show_login_form') }}">Login</a>
                                                </span>
                                                <span>
                                                <a href="{{ route('front.show_register_form') }}">Register</a>
                                                </span>
                                                @else

                                                <span><a href="{{ route('frontend.dashboard') }}">My dashboard</a></span>
                                                <span><a href="{{ route('front.logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">Logout</a></span>
                                                <form id="logout-form" action="{{ route('front.logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>

                                            </div>
                                      </li>
                    @endguest

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <!-- Start Mobile Menu -->
    <div class="row d-none">
        <div class="col-lg-12 d-none">
            <nav class="mobilemenu__nav">
                <ul class="meninmenu">
                    <li><a href="{{ route('frontend.index') }}">Home</a></li>
                    <li><a href="{{ route('frontend.index',['our-vision']) }}">Our-Vision</a></li>
                    <li><a href="{{ route('frontend.index',['about-us']) }}">About</a></li>
                    <li><a href="javascript:void(0);">Blog</a>
                        <ul>
                            <li><a href="blog.html">Un-Categoriesd</a></li>
                            <li><a href="blog.html">Flower</a></li>
                            <li><a href="blog.html">Natural</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('front.contact') }}">Contact</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- End Mobile Menu -->
    <div class="mobile-menu d-block d-lg-none">
    </div>
    <!-- Mobile Menu -->
    </div>
</header>
<!-- //Header -->
<!-- Start Search Popup -->
<div class="box-search-content search_active block-bg close__top">
    <form id="search_mini_form" class="minisearch" action="#">
        <div class="field__search">
            <input type="text" placeholder="Search entire store here...">
            <div class="action">
                <a href="#"><i class="zmdi zmdi-search"></i></a>
            </div>
        </div>
    </form>
    <div class="close__wrap">
        <span>close</span>
    </div>
</div>
<!-- End Search Popup -->
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area bg-image--4">

</div>