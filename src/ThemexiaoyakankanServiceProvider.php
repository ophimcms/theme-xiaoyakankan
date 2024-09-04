<?php

namespace Ophim\Themexiaoyakankan;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemexiaoyakankanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/xiaoyakankan')
        ], 'xiaoyakankan-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'xiaoyakankan' => [
                'name' => 'Theme xiaoyakankan',
                'author' => 'dev.ohpim.cc',
                'package_name' => 'ophimcms/theme-xiaoyakankan',
                'publishes' => ['xiaoyakankan-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'per_page_limit',
                        'label' => 'Pages limit',
                        'type' => 'number',
                        'value' => 12,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_related_limit',
                        'label' => 'Movies related limit',
                        'type' => 'number',
                        'value' => 12,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url',
                        'value' => <<<EOT
                        Phim chiếu rạp||is_shown_in_theater|1|updated_at|desc|12|/danh-sach/phim-chieu-rap
                        Phim bộ mới||type|series|updated_at|desc|12|/danh-sach/phim-bo
                        Phim lẻ mới||type|single|updated_at|desc|12|/danh-sach/phim-le
                        Hoạt hình|categories|slug|hoat-hinh|updated_at|desc|12|/the-loai/hoat-hinh
                        EOT,
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
                        'value' => '',
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
                        <footer class="gm-foot">
                            <p>
                            <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Mọi khiếu nại về bản quyền vui lòng gửi thư về địa chỉ email bên dưới, chúng tôi sẽ giải quyết sớm, xin cảm ơn.</font></font><br></p>
                        </footer>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
