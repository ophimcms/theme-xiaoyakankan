# THEME - xiaoyakankan 2024 - OPHIM CMS

## Install

    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/ophimcms/theme-xiaoyakankan.git"
        }
    ],
    "require": {
    "ophimcms/theme-xiaoyakankan": "*"
    }
1. Tại thư mục của Project: `composer update`
2. Kích hoạt giao diện trong Admin Panel
## Requirements
https://github.com/hacoidev/ophim-core
## Note
- Một vài lưu ý quan trọng của các nút chức năng:
    + `Activate` và `Re-Activate` sẽ publish toàn bộ file js,css trong themes ra ngoài public của laravel.
    + `Reset` reset lại toàn bộ cấu hình của themes
## Demo
### Trang Chủ
![Alt text](https://i.ibb.co/RP4Zsr7/image.png "Home Page")

### Trang Danh Sách Phim

![Alt text](https://i.ibb.co/1mBvf1b/image.png "Catalog Page")

### Trang Thông Tin Phim

![Alt text](https://i.ibb.co/QNmtFyG/image.png "Info Page")

### Trang Xem Phim

![Alt text](https://i.ibb.co/2W68S48/image.png "Episode Page")

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/theme-xiaoyakankan/resources/views/themexiaoyakankan`
- Copy file cần custom đến: `/resources/views/vendor/themes/themexiaoyakankan`
# THEME - xiaoyakankan 2024 - OPHIM CMS
