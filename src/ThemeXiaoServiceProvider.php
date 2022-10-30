<?php

namespace Ophim\ThemeXiao;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemeXiaoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/xiao')
        ], 'xiao-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'xiao' => [
                'name' => 'Theme Xiao',
                'author' => 'opdlnf01@gmail.com',
                'package_name' => 'ophimcms/theme-xiao',
                'publishes' => ['xiao-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'recommendations_limit',
                        'label' => 'Recommendations Limit',
                        'type' => 'number',
                        'hint' => 'Number',
                        'value' => 10,
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url|show_template (section_thumb_1_col|section_thumb_2_col)',
                        'value' => "Phim chiếu rạp mới||is_shown_in_theater|1|8|/danh-sach/phim-chieu-rap|section_thumb_1_col\r\nPhim bộ mới||type|series|6|/danh-sach/phim-bo|section_thumb_2_col\r\nPhim lẻ mới||type|single|6|/danh-sach/phim-bo|section_thumb_2_col\r\nPhim hoạt hình mới|categories|slug|hoat-hinh|6|/the-loai/phim-hoat-hinh|section_thumb_2_col",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Danh sách hot',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => "Top phim lẻ tuần||type|single|view_week|desc|5\r\nTop phim bộ tuần||type|series|view_week|desc|5\r\nTop phim hoạt hình tuần|categories|slug|hoat-hinh|view_week|desc|5\r\nTop chiếu rạp tuần||is_shown_in_theater|1|view_week|desc|5",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => 'class="active"',
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <div class="myui-foot clearfix">
                            <div class="container min">
                                <div class="row">
                                    <div class="col-pd text-center">
                                        <p>Tất cả video và hình ảnh của trên trang web đều thu thập từ Internet và bản quyền thuộc về người sáng
                                            tạo ban đầu. Trang web này chỉ cung cấp dịch vụ trang web, không cung cấp lưu trữ tài nguyên và
                                            không tham gia ghi và tải lên <br> Nếu vi phạm bản quyền của công ty bạn, vui lòng gửi email đến
                                            admin@email.com (Chúng tôi sẽ xóa nội dung vi phạm trong thời gian sớm nhất, xin cảm ơn.) </p>
                                        <p class="hidden-xs" style="display:block;">
                                            <a target="_blank" href="/">TextLink</a>
                                            <span class="split-line"></span>
                                            <a target="_blank" href="/">TextLink</a>
                                            <span class="split-line"></span>
                                            <a target="_blank" href="/">TextLink</a>
                                            <span class="split-line"></span>
                                            <a target="_blank" href="/">TextLink</a>
                                            <span class="split-line"></span>
                                            <a target="_blank" href="/">TextLink</a>
                                            <span class="split-line"></span>
                                            <a target="_blank" href="/">TextLink</a>
                                            <span class="split-line"></span>
                                            <a target="_blank" href="/">TextLink</a>
                                        </p>
                                        <p class="margin-0">© 2022 OPHIMCMS Allrights Reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="myui-extra clearfix">
                            <li>
                                <a class="backtop" href="javascript:scroll(0,0)" title="Lên đầu trang" style="display: none;">
                                    <i class="fa fa-angle-up"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btnskin" href="javascript:;" title="Giao diện">
                                    <i class="fa fa-paint-brush"></i>
                                </a>
                            </li>
                        </ul>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
