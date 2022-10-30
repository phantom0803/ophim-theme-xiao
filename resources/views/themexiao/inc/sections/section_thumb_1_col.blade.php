<div class="myui-panel myui-panel-bg clearfix">
    <div class="myui-panel-box clearfix">
        <div class="myui-panel_hd">
            <div class="myui-panel__head clearfix">
                @if ($item['link'])
                    <span class="text-muted more pull-right"><span class="split-line"></span><a href="{{$item['link']}}">Xem thêm</a></span>
                @endif
                <h3 class="title">{{$item['label']}}</h3>
            </div>
        </div>
        <div class="myui-panel_bd clearfix">
            <ul class="myui-vodlist clearfix">
                @foreach ($item['data'] as $movie)
                    <li class="col-lg-8 col-md-8 col-sm-4 col-xs-3">
                        @include('themes::themexiao.inc.sections.movie_card')
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
