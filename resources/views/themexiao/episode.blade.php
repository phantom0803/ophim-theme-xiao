@extends('themes::themexiao.layout')

@push('header')
    <style>
        .myui-player__operate {
            justify-content: space-between;
            padding: 10px 10px !important;
            justify-items: center;
            flex-direction: row;
            align-items: center;
        }

        .myui-player__operate ul {
            display: flex;
        }

        .myui-player__operate > li > a.streaming-server {
            cursor: pointer;
            padding: 4px 8px;
            color: #fff;
            margin-bottom: 2px;
        }

        .myui-player__operate > li > a.streaming-server:hover {
            background: #ff9e11;
        }
        .myui-player__operate > li > a.streaming-server.active, .myui-content__list li a.active {
            background-color: #f90;
            background: linear-gradient(to right,#ff9900 0,#ff9f16 100%);
        }

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

@section('player')
    <div class="myui-player clearfix" style="background-color: #27272f;">
        <div class="container">
            <div class="row">
                <div class="myui-player__item clearfix" style="background-color: #1f1f1f;">
                    <div class="col-lg-wide-75 col-md-wide-65 clearfix padding-0 relative" id="player-left">
                        <div class="myui-player__box">
                            <div id="player-area" class="embed-responsive clearfix">

                            </div>
                        </div>
                        <ul class="myui-player__operate" style="background-color: #1b1a25;">
                            <li class="hidden-xs">Chọn nguồn phát hoặc tải lại trang khi lỗi</li>
                            <li>
                                @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                                    <a data-id="{{ $server->id }}" data-link="{{ $server->link }}" data-type="{{ $server->type }}"
                                        onclick="chooseStreamingServer(this)" class="btn btn-min btn-gray streaming-server">
                                            <i class='icon-play'></i>
                                            <span class='title'>Nguồn #{{ $loop->index + 1 }}</span>
                                            <span class='loader'></span>
                                    </a>
                                @endforeach
                            </li>
                            <li>
                                <a href="javascript:;" onclick="window.location.reload()"><i class="fa fa-spinner"></i> Tải lại trang</a>
                            </li>
                        </ul>
                        <style type="text/css">
                            .embed-responsive {
                                padding-bottom: 56.25%;
                            }
                        </style>
                        <a class="is-btn hidden-sm hidden-xs" id="player-sidebar-is" href="javascript:;"><i
                                class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="col-lg-wide-25 col-md-wide-35 padding-0" id="player-sidebar">
                        <div class="myui-panel active clearfix">
                            <div class="myui-panel-box clearfix">
                                <div class="col-pd clearfix">
                                    <div class="myui-panel__head active clearfix">
                                        <h3 class="title text-fff">{{$currentMovie->name}}
                                            <small class="text-red">Tập {{$episode->name}}</small>
                                        </h3>
                                    </div>
                                    <div class="box-rating">
                                        <input id="hint_current" type="hidden" value="">
                                        <input id="score_current" type="hidden"
                                            value="{{ number_format($currentMovie->rating_star ?? 0, 1) }}">
                                        <div id="star" data-score="{{ number_format($currentMovie->rating_star ?? 0, 1) }}"
                                            style="cursor: pointer; float: left; width: 200px;">
                                        </div>
                                        <span id="hint"></span>
                                        <div id="div_average" style="float:left; line-height:20px; margin:0 5px; ">(<span class="average"
                                                id="average">{{ number_format($currentMovie->rating_star ?? 0, 1) }}</span> đ/<span
                                                id="rate_count"> /
                                                {{ $currentMovie->rating_count ?? 0 }}</span> lượt)
                                        </div>
                                        <meta itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating" />
                                        <meta itemprop="ratingValue" content="{{ number_format($currentMovie->rating_star ?? 0, 1) }}" />
                                        <meta itemprop="ratingcount" content="{{ $currentMovie->rating_count ?? 0 }}" />
                                        <meta itemprop="bestRating" content="10" />
                                        <meta itemprop="worstRating" content="1" />
                                    </div>
                                    <div class="text-muted">
                                        <ul class="nav nav-tabs pull-right">
                                            <li class="dropdown pb10 margin-0">
                                                <a href="javascript:;" class="padding-0 text-fff" data-toggle="dropdown">Chọn Server ({{count($currentMovie->episodes->groupBy('server'))}}) <i class="fa fa-angle-down"></i></a>
                                                <div class="dropdown-box bottom">
                                                    <ul class="item">
                                                        @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                                                            <li class="@if ($episode->server == $server) active @endif">
                                                                <a href="#player{{$loop->index}}" tabindex="-1" data-toggle="tab">{{$server}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content mb10">
                                    @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                                        <div id="player{{$loop->index}}" class="tab-pane fade in @if ($episode->server == $server) active @endif clearfix">
                                            <ul class="myui-content__list playlist clearfix " id="playlist">
                                                @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                                                    <li class="col-lg-4 col-md-4 col-sm-5 col-xs-4 @if ($item->contains($episode)) active @endif">
                                                        <a class="btn btn-min btn-gray @if ($item->contains($episode)) active @endif" href="{{ $item->sortByDesc('type')->first()->getUrl() }}">{{$name}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="myui-player__data hidden-xs clearfix">
                    <h1 class="title">{{ $currentMovie->name }}</h1>
                    <h2 class="font-18 text-muted">{{ $currentMovie->origin_name }}</h2>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-lg-wide-75 col-md-wide-7 col-xs-1 padding-0">
        <div class="myui-panel myui-panel-bg clearfix" id="desc">
            <div class="myui-panel-box clearfix">
                <div class="myui-panel_hd">
                    <div class="myui-panel__head active bottom-line clearfix">
                        <h3 class="title">Thông tin</h3>
                    </div>
                </div>
                <div class="myui-panel_bd">
                    <div class="col-pd text-collapse content">
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

                        <p>
                            <span class="text-muted">Đạo diễn: </span>
                            @if(count($currentMovie->directors))
                                {!! $currentMovie->directors->map(function ($director) {
                                    return '<a href="' .
                                        $director->getUrl() .
                                        '" title="Đạo diễn ' .
                                        $director->name .
                                        '" rel="director tag">' .
                                        $director->name .
                                        '</a>';
                                })->implode(', ') !!}
                            @else
                                N/A
                            @endif
                        </p>
                        <p>
                            <span class="text-muted">Diễn viên: </span>
                            @if(count($currentMovie->directors))
                                {!! $currentMovie->actors->map(function ($actor) {
                                    return '<a href="' .
                                        $actor->getUrl() .
                                        '" title="Diễn viên ' .
                                        $actor->name .
                                        '" rel="actor tag">' .
                                        $actor->name .
                                        '</a>';
                                })->implode(', ') !!}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
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
    <script src="/themes/xiao/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/xiao/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        jQuery(document).ready(function() {
            jQuery('html, body').animate({
                scrollTop: jQuery('#player-area').offset().top
            }, 'slow');
        });
    </script>

    <script>
        const wrapper = document.getElementById('player-area');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link;
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname +
                "?id=" + id;

            history.pushState({
                path: newUrl
            }, "", newUrl);


            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('active');
            })
            el.classList.add('active');

            link.replace('http://', 'https://');
            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/xiao/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        jQuery("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="445px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        jQuery("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="445px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        jQuery("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="445px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="445px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    image: "{{ $currentMovie->poster_url ?: $currentMovie->thumb_url }}",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }


                const resumeData = 'OPCMS-PlayerPosition-' + id;
                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const episode = urlParams.get('id')
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

    <link href="{{ asset('/themes/hhtq/libs/jquery-raty/jquery.raty.css') }}" rel="stylesheet" />
    <script src="{{ asset('/themes/hhtq/libs/jquery-raty/jquery.raty.js') }}"></script>

    <script>
        var rated = false;
        jQuery(document).ready(function($) {
            $('#star').raty({
                number: 10,
                starHalf: '/themes/hhtq/libs/jquery-raty/images/star-half.png',
                starOff: '/themes/hhtq/libs/jquery-raty/images/star-off.png',
                starOn: '/themes/hhtq/libs/jquery-raty/images/star-on.png',
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
                                alert("Đánh giá của bạn đã được gửi đi!")
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
