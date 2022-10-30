@extends('themes::themexiao.layout')

@php
    use Ophim\Core\Models\Movie;

    $recommendations = Cache::remember('site.movies.recommendations', setting('site_cache_ttl', 5 * 60), function () {
        return Movie::where('is_recommended', true)
            ->limit(get_theme_option('recommendations_limit', 10))
            ->orderBy('updated_at', 'desc')
            ->get();
    });

    $data = Cache::remember('site.movies.latest', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('latest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $limit, $link, $template] = array_merge($list, ['Phim mới cập nhật', '', 'type', 'series', 8, '/', 'section_thumb_1_col']);
                try {
                    $top_limit = floor($limit / 6) * 10;
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->limit($limit)
                            ->orderBy('updated_at', 'desc')
                            ->get(),
                        'top_view' =>
                            $template == 'section_thumb_2_col'
                                ? Movie::when($relation, function ($query) use ($relation, $field, $val) {
                                    $query->whereHas($relation, function ($rel) use ($field, $val) {
                                        $rel->where($field, $val);
                                    });
                                })
                                    ->when(!$relation, function ($query) use ($field, $val) {
                                        $query->where($field, $val);
                                    })
                                    ->limit($top_limit)
                                    ->orderBy('view_total', 'desc')
                                    ->get()
                                : [],
                        'link' => $link,
                    ];
                } catch (\Exception $e) {
                }
            }
        }
        return $data;
    });
@endphp

@section('slider_recommended')
    @include('themes::themexiao.inc.sections.slider_recommended')
@endsection

@section('sidebar')
    @include('themes::themexiao.inc.sidebar', ['page' => 'index'])
@endsection

@section('content')
    @foreach ($data as $item)
        @include('themes::themexiao.inc.sections.' . $item['template'])
    @endforeach
@endsection
