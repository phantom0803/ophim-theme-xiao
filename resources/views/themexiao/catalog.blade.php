@extends('themes::themexiao.layout')

@php
$years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
    return \Ophim\Core\Models\Movie::select('publish_year')
        ->distinct()
        ->pluck('publish_year')
        ->sortDesc();
});
@endphp

@section('content')
    @include('themes::themexiao.inc.catalog_filter')
    <div class="myui-panel myui-panel-bg clearfix">
        <div class="myui-panel-box clearfix">
            <div class="myui-panel_bd">
                <ul class="myui-vodlist clearfix">
                    @foreach ($data as $movie)
                        <li class="col-lg-8 col-md-6 col-sm-4 col-xs-3">
                            @include('themes::themexiao.inc.sections.movie_card')
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    {{ $data->appends(request()->all())->links('themes::themexiao.inc.pagination') }}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function URL_add_parameter(url, param, value){
                var hash       = {};
                var parser     = document.createElement('a');

                parser.href    = url;

                var parameters = parser.search.split(/\?|&/);

                for(var i=0; i < parameters.length; i++) {
                    if(!parameters[i])
                        continue;

                    var ary      = parameters[i].split('=');
                    hash[ary[0]] = ary[1];
                }

                hash[param] = value;

                var list = [];
                Object.keys(hash).forEach(function (key) {
                    list.push(key + '=' + hash[key]);
                });

                parser.search = '?' + encodeURI(list.join('&'));
                return parser.href;
            }

            $("#panel_filter ul li span").on('click', function (e) {
                var filterUrl = location.origin + decodeURI(location.search);
                var filterName = e.target.getAttribute('filter-name');
                var filterValue = e.target.getAttribute('filter-value');
                location.href = URL_add_parameter(filterUrl, filterName, filterValue);
            })
        });
    </script>
@endpush
