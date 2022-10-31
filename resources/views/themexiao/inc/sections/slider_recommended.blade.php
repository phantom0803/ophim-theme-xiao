<div class="myui-panel radius-0 padding-0 clearfix">
    <div id="home_slide" class="carousel clearfix" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($recommendations as $movie)
                <div class="item text-center @if ($loop->first) active @endif" >
                    <a title="{{$movie->name}}" href="{{$movie->getUrl()}}">
                        <img style="width: 2074px; height: 690px;" class="img-responsive hidden-xs" src="{{$movie->poster_url ?: $movie->thumb_url}}" />
                    </a>
                </div>
            @endforeach
        </div>
        <ul class="carousel-indicators carousel-indicators-text hidden-md hidden-sm hidden-xs">
            @foreach ($recommendations as $movie)
                <li data-target="#home_slide" data-slide-to="{{$loop->index}}" class="@if ($loop->first) active @endif">
                    <h4 class="title">{{$movie->name}}</h4>
                    <p class="text margin-0">{{$movie->origin_name}} ({{$movie->publish_year}})</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<script>
    $('.carousel-indicators li').on('mouseover', function() {
        $(this).trigger('click');
    })
</script>
