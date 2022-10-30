@extends('themes::themexiao.layout')

@php
    $watch_url = '';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watch_url = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
@endphp

@push('header')
    <style>
        @media(max-width:767px) {
            #star img {
                width: 18px;
                height: 18px;
            }
        }

        @media(max-width:360px) {
            #star img {
                width: 16px;
                height: 16px;
            }
        }
    </style>
@endpush

@section('sidebar')
    <div class="col-lg-wide-25 col-md-wide-3 col-xs-1 myui-sidebar hidden-sm hidden-xs">
        @include('themes::themexiao.inc.sidebar', ['page' => 'single'])
    </div>
@endsection

@section('content')
    <div class="col-lg-wide-75 col-md-wide-7 col-xs-1 padding-0">
        <div class="myui-panel myui-panel-bg clearfix">
            <div class="myui-panel-box clearfix">
                <div class="col-xs-1">
                    <span class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                        <span itemscope itemtype="http://schema.org/ListItem">
                            <a itemprop="item" itemprop="url" href="/" title="Trang Chủ">
                                <span itemprop="name">
                                    <i class="fa fa-home"></i> Phim Mới <i class="fa fa-angle-right"></i>
                                </span>
                            </a>
                            <meta itemprop="position" content="1" />
                        </span>
                        @foreach ($currentMovie->categories as $category)
                            <span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <a itemprop="item" href="{{ $category->getUrl() }}" title="{{ $category->name }}">
                                    <span itemprop="name">
                                        {{ $category->name }} <i class="fa fa-angle-right"></i>
                                    </span>
                                </a>
                                <meta itemprop="position" content="2">
                            </span>
                        @endforeach
                        <span>{{$currentMovie->name}}</span>
                    </span>
                </div>
                <div class="col-xs-1">
                    <div class="myui-content__thumb">
                        <a class="myui-vodlist__thumb picture" href="/watch/black-adam" title="黑亚当">
                            <img class="lazyload" src="/themes/xiao/img/0e1ec6516.gif"
                                data-original="{{ $currentMovie->thumb_url }}" />
                            <span class="play hidden-xs"></span>
                        </a>
                    </div>
                    <div class="myui-content__detail">
                        <h1 class="title">{{ $currentMovie->name }}</h1>
                        <h2 class="font-18 text-muted">{{ $currentMovie->origin_name }}</h2>

                        <div class="data">
                            <input id="hint_current" type="hidden" value="" />
                            <input id="score_current" type="hidden" value="{{ number_format($currentMovie->rating_star ?? 0, 1) }}" />
                            <div id="star" data-score="{{ number_format($currentMovie->rating_star ?? 0, 1) }}" style="cursor: pointer;"></div>
                            <span id="hint"></span>
                            <div id="div_average" style="">
                                (<span class="average" id="average">{{ number_format($currentMovie->rating_star ?? 0, 1) }}</span> đ/<span id="rate_count"> / {{ $currentMovie->rating_count ?? 0 }}</span> lượt)
                            </div>
                            <span class="hidden" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                                <meta itemprop="ratingValue" content="{{ number_format($currentMovie->rating_star ?? 0, 1) }}" />
                                <meta itemprop="ratingcount" content="{{ $currentMovie->rating_count ?? 0 }}" />
                                <meta itemprop="bestRating" content="10" />
                                <meta itemprop="worstRating" content="1" />
                            </span>
                        </div>

                        <p class="data">
                            <span class="text-muted">Định dạng: </span>
                            <a href="{{$currentMovie->type == 'series' ? '/danh-sach/phim-bo' : '/danh-sach/phim-le'}}">{{$currentMovie->type == 'series' ? 'Phim Bộ' : 'Phim Lẻ'}}</a>
                            <span class="split-line"></span>
                            <span class="text-muted hidden-xs">Quốc gia: </span>
                            {!! $currentMovie->regions->map(function ($region) {
                                return '<a href="' .
                                    $region->getUrl() .
                                    '" title="' .
                                    $region->name .
                                    '" rel="region tag">' .
                                    $region->name .
                                    '</a>';
                            })->implode(', ') !!}
                            <span class="split-line"></span>
                            <span class="text-muted hidden-xs">Năm sản xuất: </span>
                            {{$currentMovie->publish_year}}
                            <span class="split-line"></span>
                            <span class="text-muted hidden-xs">Lượt xem: </span>
                            <i class="fa fa-eye"></i> {{$currentMovie->view_total}}
                        </p>
                        <p class="data hidden-sm">
                            <span class="text-muted">Trạng thái: </span>
                            <span class="text-red">{{$currentMovie->episode_current}}</span>
                        </p>
                        <p class="data">
                            <span class="text-muted">Thể loại: </span>
                            {!! $currentMovie->categories->map(function ($category) {
                                return '<a href="' .
                                    $category->getUrl() .
                                    '" title="' .
                                    $category->name .
                                    '" rel="category tag">' .
                                    $category->name .
                                    '</a>';
                            })->implode(', ') !!}
                        </p>
                        @if(count($currentMovie->directors))
                        <p class="data hidden-xs">
                            <span class="text-muted">Đạo diễn: </span>
                            {!! $currentMovie->directors->map(function ($director) {
                                return '<a href="' .
                                    $director->getUrl() .
                                    '" title="Đạo diễn ' .
                                    $director->name .
                                    '" rel="director tag">' .
                                    $director->name .
                                    '</a>';
                            })->implode(', ') !!}
                        </p>
                        @endif
                        @if(count($currentMovie->actors))
                        <p class="data hidden-xs">
                            <span class="text-muted">Diễn viên: </span>
                            {!! $currentMovie->actors->map(function ($actor) {
                                return '<a href="' .
                                    $actor->getUrl() .
                                    '" title="Diễn viên ' .
                                    $actor->name .
                                    '" rel="actor tag">' .
                                    $actor->name .
                                    '</a>';
                            })->implode(', ') !!}
                        </p>
                        @endif
                    </div>
                    <div class="myui-content__operate">
                        @if ($watch_url)
                            <a class="btn btn-warm" href="{{$watch_url}}">
                                <i class="fa fa-play"></i> XEM PHIM </a>
                        @endif
                        @if ($currentMovie->trailer_url)
                            <a class="btn btn-danger" href="{{$currentMovie->trailer_url}}" target="_blank">
                                <i class="fa fa-star"></i>Trailer </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="myui-panel myui-panel-bg clearfix" id="desc">
            <div class="myui-panel-box clearfix">
                <div class="myui-panel_hd">
                    <div class="myui-panel__head active bottom-line clearfix">
                        <h3 class="title">Nội dung phim</h3>
                    </div>
                </div>
                <div class="myui-panel_bd">
                    <div class="col-pd text-collapse content">
                        @if ($currentMovie->content)
                            {!! $currentMovie->content !!}
                        @else
                            <p>Hãy xem phim để cảm nhận nhé...</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="myui-panel myui-panel-bg clearfix">
            <div class="myui-panel-box clearfix">
                <div class="myui-panel_hd">
                    <div class="myui-panel__head active bottom-line clearfix">
                        <a class="more sort-button pull-right" href="javascript:;">
                            <i class="fa fa-sort-amount-asc"></i>Sắp xếp </a>
                        <h3 class="title">Danh sách tập</h3>
                        <ul class="nav nav-tabs active">
                            @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                                <li>
                                    <a href="#playlist{{$loop->index}}" data-toggle="tab">{{$server}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-content myui-panel_bd">
                    @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                        <div id="playlist{{$loop->index}}" class="tab-pane fade in clearfix">
                            <ul class="myui-content__list scrollbar sort-list clearfix"
                                style="max-height: 300px; overflow: auto;">
                                @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                                    <li title="{{ (strpos(strtolower($name), 'tập')) ? $name : 'Tập ' . $name }}" class="col-lg-7 col-md-6 col-sm-4 col-xs-2">
                                        <a class="btn btn-default" href="{{ $item->sortByDesc('type')->first()->getUrl() }}">{{ (strpos(strtolower($name), 'tập')) ? $name : 'Tập ' . $name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="myui-panel-box clearfix">
            <div class="myui-panel_bd">
                <div class="myui-panel_hd">
                    <div class="myui-panel__head clearfix">
                        <h3 class="title">Bình luận</h3>
                    </div>
                </div>
                <div class="myui-panel_bd">
                    <div class="fb-comments" data-href="{{ $currentMovie->getUrl() }}" data-width="100%" data-colorscheme="dark" data-numposts="5" data-order-by="reverse_time" data-lazy="true"></div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(".tab-pane:first,.nav-tabs li:first").addClass("active");
        </script>
        <div class="myui-panel myui-panel-bg clearfix">
            <div class="myui-panel-box clearfix">
                <div class="myui-panel_hd">
                    <div class="myui-panel__head active bottom-line clearfix">
                        <h3 class="title">Có thể bạn muốn xem</h3>
                    </div>
                </div>
                <div class="tab-content myui-panel_bd">
                    <ul id="actor" class="myui-vodlist__bd tab-pane fade in active clearfix">
                        @foreach ($movie_related as $movie)
                        <li class="col-lg-6 col-md-6 col-sm-4 col-xs-3">
                            @include('themes::themexiao.inc.sections.movie_card')
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="{{ asset('/themes/xiao/libs/jquery-raty/jquery.raty.css') }}" rel="stylesheet" />
    <script src="{{ asset('/themes/xiao/libs/jquery-raty/jquery.raty.js') }}"></script>

    <script>
        var rated = false;
        jQuery(document).ready(function($) {
            $('#star').raty({
                number: 10,
                starHalf: '/themes/xiao/libs/jquery-raty/images/star-half.png',
                starOff: '/themes/xiao/libs/jquery-raty/images/star-off.png',
                starOn: '/themes/xiao/libs/jquery-raty/images/star-on.png',
                click: function(score, evt) {
                    if (!rated) {
                        $.ajax({
                            url: '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}',
                            data: JSON.stringify({
                                rating: score
                            }),
                            headers: {
                                "Content-Type": "application/json",
                                'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]')
                                    .getAttribute(
                                        'content')
                            },
                            type: 'post',
                            dataType: 'json',
                            success: function(res) {
                                layer.msg(
                                    "Đánh giá của bạn đã được gửi đi.",
                                    {
                                        anim: 5,
                                        time: 3000,
                                    },
                                    function () {
                                    }
                                );
                                rated = true;
                            }
                        });
                    }
                }
            });
        })
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
