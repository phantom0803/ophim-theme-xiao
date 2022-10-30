<div class="myui-panel active myui-panel-bg2 clearfix" style="margin-top: 30px">

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
            <span>{{ $section_name ?? 'Danh Sách Phim' }}</span>
        </span>
    </div>

    <div class="myui-panel-box clearfix">
        <div class="myui-panel_hd">
            <div class="myui-panel__head active bottom-line clearfix"><a class="slideDown-btn more pull-right"
                    href="javascript:;">Thu gọn <i class="fa fa-angle-up"></i></a>
                <h3 class="title">{{ $section_name }}</h3>
            </div>
        </div>
        <div id="panel_filter" class="myui-panel_bd">
            <div class="slideDown-box">
                <ul class="myui-screen__list nav-slide clearfix" data-align="left">
                    <li><a class="btn text-muted">Định dạng</a></li>
                    <li><span filter-name="filter[type]" filter-value="" class="btn @if (!isset(request('filter')['type'])) btn-warm @endif">Toàn bộ</span></li>
                    <li><span filter-name="filter[type]" filter-value="series" class="btn @if (isset(request('filter')['type']) && request('filter')['type'] == 'series') btn-warm @endif">Phim bộ</span></li>
                    <li><span filter-name="filter[type]" filter-value="single" class="btn @if (isset(request('filter')['type']) && request('filter')['type'] == 'single') btn-warm @endif">Phim lẻ</span></li>
                </ul>
                <ul class="myui-screen__list nav-slide clearfix" data-align="left">
                    <li><a class="btn text-muted">Thể loại</a></li>
                    <li><span filter-name="filter[category]" filter-value="" class="btn @if (!isset(request('filter')['category'])) btn-warm @endif">Toàn bộ</span>
                    </li>
                    @foreach (\Ophim\Core\Models\Category::fromCache()->all() as $item)
                        <li><span filter-name="filter[category]" filter-value="{{$item->id}}" class="btn @if ((isset(request('filter')['category']) && request('filter')['category'] == $item->id) ||
                            (isset($category) && $category->id == $item->id)) btn-warm @endif"
                               >{{ $item->name }}</span></li>
                    @endforeach
                </ul>
                <ul class="myui-screen__list nav-slide clearfix" data-align="left">
                    <li><a class="btn text-muted">Quốc gia</a></li>
                    <li><span filter-name="filter[region]" filter-value="" class="btn @if (!isset(request('filter')['region'])) btn-warm @endif">Toàn bộ</span>
                    </li>
                    @foreach (\Ophim\Core\Models\Region::fromCache()->all() as $item)
                        <li><span filter-name="filter[region]" filter-value="{{$item->id}}" class="btn @if ((isset(request('filter')['region']) && request('filter')['region'] == $item->id) ||
                            (isset($region) && $region->id == $item->id)) btn-warm @endif"
                               >{{ $item->name }}</span></li>
                    @endforeach
                </ul>
                <ul class="myui-screen__list nav-slide clearfix" data-align="left">
                    <li><a class="btn text-muted">Năm</a></li>
                    <li><span filter-name="filter[year]" filter-value="" class="btn @if (!isset(request('filter')['year'])) btn-warm @endif">Toàn bộ</span></li>
                    @foreach ($years as $year)
                        <li><span filter-name="filter[year]" filter-value="{{$year}}" class="btn @if (isset(request('filter')['year']) && request('filter')['year'] == $year) btn-warm @endif">{{ $year }}</span></li>
                    @endforeach
                </ul>
            </div>
            <ul class="myui-screen__list nav-slide clearfix" data-align="left">
                <li><a class="btn text-muted">Sắp xếp</a></li>
                <li><span filter-name="filter[sort]" filter-value="" class="btn @if (!isset(request('filter')['sort'])) btn-warm @endif">Mặc định</span></li>
                <li><span filter-name="filter[sort]" filter-value="update" class="btn @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'update') btn-warm @endif">Thời gian cập nhật</span></li>
                <li><span filter-name="filter[sort]" filter-value="create" class="btn @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'create') btn-warm @endif">Thời gian đăng</span></li>
                <li><span filter-name="filter[sort]" filter-value="year" class="btn @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'year') btn-warm @endif">Năm sản xuất</span></li>
                <li><span filter-name="filter[sort]" filter-value="view" class="btn @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'view') btn-warm @endif">Lượt xem</span></li>
            </ul>
        </div>
    </div>
</div>
