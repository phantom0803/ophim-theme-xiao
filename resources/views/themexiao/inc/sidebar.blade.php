@php
$tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
    $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
    $data = [];
    foreach ($lists as $list) {
        if (trim($list)) {
            $list = explode('|', $list);
            [$label, $relation, $field, $val, $sortKey, $alg, $limit] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 5]);
            try {
                $data[] = [
                    'label' => $label,
                    'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                        $query->whereHas($relation, function ($rel) use ($field, $val) {
                            $rel->where($field, $val);
                        });
                    })
                        ->when(!$relation, function ($query) use ($field, $val) {
                            $query->where($field, $val);
                        })
                        ->orderBy($sortKey, $alg)
                        ->limit($limit)
                        ->get(),
                ];
            } catch (\Exception $e) {
                # code
            }
        }
    }

    return $data;
});
@endphp

<div class="myui-panel myui-panel-bg hiddex-xs clearfix">
    <div class="myui-panel-box clearfix">
        @foreach ($tops as $top)
            @if($page == 'index') <div class="col-lg-4 col-md-4 col-sm-2 col-xs-1 padding-0"> @endif
                <div class="myui-panel_hd">
                    <div class="myui-panel__head clearfix">
                        <h3 class="title">{{ $top['label'] }}</h3>
                    </div>
                </div>
                <div class="myui-panel_bd">
                    @if (count($top['data']))
                        <ul class="myui-vodlist__media active col-pd clearfix">
                            <li>
                                <div class="thumb"><a class="myui-vodlist__thumb img-xs-70 lazyload"
                                        href="{{ $top['data']->first()->getUrl() }}"
                                        title="{{ $top['data']->first()->name }}"
                                        data-original="{{ $top['data']->first()->thumb_url }}"></a></div>
                                <div class="detail detail-side">
                                    <h4 class="title"><a href="{{ $top['data']->first()->getUrl() }}"><i
                                                class="fa fa-angle-right text-muted pull-right"></i>{{ $top['data']->first()->name }}</a>
                                    </h4>
                                    <p class="font-12"><span
                                            class="text-muted">{{ $top['data']->first()->origin_name }}</span><span
                                            class="text-muted"> ({{ $top['data']->first()->publish_year }})</span></p>
                                    <p class="font-12 margin-0">
                                        <span class="text-muted"><i class="fa fa-eye"></i>
                                        </span>{{ $top['data']->first()->view_week }}
                                        <span class="text-muted"><i class="fa fa-star"></i>
                                        </span>{{ number_format($top['data']->first()->rating_star ?? 0, 1) }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                        <ul class="myui-vodlist__text col-pd clearfix">
                            @foreach ($top['data'] as $key => $movie)
                                @php
                                    switch ($key) {
                                        case 0:
                                            $class_top = 'badge-first';
                                            break;
                                        case 1:
                                            $class_top = 'badge-second';
                                            break;
                                        case 2:
                                            $class_top = 'badge-third';
                                            break;
                                        default:
                                            $class_top = '';
                                            break;
                                    }
                                @endphp
                                <li>
                                    <a href="{{ $movie->getUrl() }}" title="{{ $movie->name }}"><span class="badge {{ $class_top }}">{{ $key + 1 }}</span>{{ $movie->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @if($page == 'index') </div> @endif
        @endforeach
    </div>
</div>
