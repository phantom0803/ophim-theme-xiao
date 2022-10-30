# THEME - XIAO 2022 - OPHIM CMS

## Demo
### Trang Chủ
![Alt text](https://i.ibb.co/1z0FBcy/XIAO-DARK-INDEX.png "Home Page")
![Alt text](https://i.ibb.co/g3R99qz/XIAO-LIGHT-INDEX.png "Home Page")

### Trang Danh Sách Phim
![Alt text](https://i.ibb.co/7vsGz3f/XIAO-DARK-CATALOG.png "Catalog Page")
![Alt text](https://i.ibb.co/vBwvHWm/XIAO-LIGHT-CATALOG.png "Catalog Page")

### Trang Thông Tin Phim
![Alt text](https://i.ibb.co/26SH4H2/XIAO-DARK-SINGLE.png "Single Page")
![Alt text](https://i.ibb.co/YRHZRmc/XIAO-LIGHT-EPISODE.png "Single Page")

### Trang Xem Phim
![Alt text](https://i.ibb.co/wwXbb4v/XIAO-DARK-EPISODE.png "Episode Page")
![Alt text](https://i.ibb.co/7rvDPZG/XIAO-LIGHT-SINGLE.png "Episode Page")

## Requirements
https://github.com/hacoidev/ophim-core

## Install
1. Tại thư mục của Project: `composer require ophimcms/ophim-xiao`
2. Kích hoạt giao diện trong Admin Panel

## Update
1. Tại thư mục của Project: `composer update ophimcms/ophim-xiao`
2. Re-Activate giao diện trong Admin Panel

## Document
### List
- Trang chủ: `display_label|relation|find_by_field|value|limit|show_more_url|show_template (section_thumb_1_col|section_thumb_2_col)`
    + Ví dụ theo định dạng: `Phim bộ mới||type|series|6|/danh-sach/phim-bo|section_thumb_2_col`
    + Ví dụ theo định dạng: `Phim lẻ mới||type|single|6|/danh-sach/phim-bo|section_thumb_2_col`
    + Ví dụ theo thể loại: `Phim hoạt hình mới|categories|slug|hoat-hinh|6|/the-loai/phim-hoat-hinh|section_thumb_2_col`
    + Ví dụ theo quốc gia: `Phim hàn quốc|regions|slug|han-quoc|16|/quoc-gia/han-quoc|section_thumb_1_col`
    + Ví dụ với các field khác: `Phim chiếu rạp mới||is_shown_in_theater|1|8|/danh-sach/phim-chieu-rap|section_thumb_1_col`

- Danh sách hot:  `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit`
    + `Phim sắp chiếu||status|trailer|publish_year|desc|9`
    + `Top phim bộ||type|series|view_total|desc|9`
    + `Top phim lẻ||type|single|view_total|desc|9`

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/theme-xiao/resources/views/themexiao`
- Copy file cần custom đến: `/resources/views/vendor/themes/themexiao`
