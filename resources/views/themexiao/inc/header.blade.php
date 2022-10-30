@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<header class="myui-header__top clearfix" id="header-top">
    <div class="container">
        <div class="row">
            <div class="myui-header_bd clearfix">
                <div class="myui-header__logo">
                    <a class="logo" href="/">
                        @if ($logo)
                            {!! $logo !!}
                        @else
                            {!! $brand !!}
                        @endif
                    </a>
                </div>
                <ul class="myui-header__menu nav-menu">
                    @foreach ($menu as $item)
                        @if (count($item['children']))
                            <li class="dropdown-hover hidden-sm hidden-xs"><a href="{{$item['link']}}">{{$item['name']}} <i class="fa fa-angle-down"></i></a>
                                <div class="dropdown-box bottom fadeInDown clearfix">
                                    <ul class="item nav-list clearfix">
                                        @foreach ($item['children'] as $children)
                                            <li class="col-lg-5 col-md-5 col-sm-5 col-xs-3"><a class="btn btn-sm btn-block btn-default" href="{{$children['link']}}">{{$children['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @else
                            <li class=" hidden-sm hidden-xs"><a href="{{$item['link']}}">{{$item['name']}}</a></li>
                        @endif
                    @endforeach

                    <li class="dropdown-hover visible-sm visible-xs"><a href="javascript:;"><i class="fa fa-bars fa-xl"></i></a>
                        <div class="dropdown-box bottom fadeInDown clearfix">
                            <ul class="item nav-list clearfix">
                                @foreach ($menu as $item)
                                    @if (count($item['children']))
                                    @else
                                        <li class="col-lg-5 col-md-5 col-sm-5 col-xs-3"><a class="btn btn-sm btn-block btn-default" href="{{$item['link']}}">{{$item['name']}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                </ul>
                <div class="myui-header__search search-box">
                    <form id="search-form" method="get" action="/">
                        <input type="text" id="search" name="search" class="search_wd form-control" value="{{request('search')}}" placeholder="Tìm kiếm phim..." autocomplete="off" />
                        <button class="submit search_submit" id="searchbutton" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <a class="search-close visible-xs" href="javascript:;"><i class="fa fa-close"></i></a>
                </div>
                <ul class="myui-header__user">
                    <li class="visible-xs"><a class="open-search" href="javascript:;"><i class="fa fa-search"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
