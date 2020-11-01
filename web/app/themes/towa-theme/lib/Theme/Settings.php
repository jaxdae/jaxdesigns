<?php

namespace Towa\Theme\Theme;

class Settings
{
    public function __construct()
    {
        $this->hide_admin_bar();
        $this->acf();
        $this->personalized_login_area();
        $this->redirect_after_login();
        $this->tiny_mce_settings();
    }

    public function hide_admin_bar()
    {
        show_admin_bar(env('SHOW_ADMIN_BAR')?: false);
    }

    public function acf()
    {
        add_action('acf/init', function () {
            acf_update_setting('google_api_key', env('GOOGLE_MAPS'));
        });
    }

    public function redirect_after_login()
    {
        add_filter('login_redirect', function ($url, $query, $user) {
            return admin_url('edit.php?post_type=page');
        }, 10, 3);
    }

    public function tiny_mce_settings()
    {
        add_filter('mce_buttons', function () {
            return [
                'formatselect', 'styleselect',
                'bold', 'italic', 'separator',
                'bullist', 'numlist', 'blockquote', 'separator',
                'link', 'unlink', 'separator',
            ];
        });

        add_filter('tiny_mce_before_init', function ($settings) {
            $style_formats = [
                [
                    'title' => 'Button',
                    'selector' => 'a',
                    'classes' => 'Wysiwyg__button',
                ],
                [
                    'title' => 'Button Secondary',
                    'selector' => 'a',
                    'classes' => 'Wysiwyg__button-secondary',
                ],
            ];

            $settings['style_formats'] = json_encode($style_formats);
            $settings['body_class'] = 'Wysiwyg';

            $settings['block_formats'] = 'Absatz=p;Überschrift 2=h2;Überschrift 3=h3;Überschrift 4=h4;Überschrift 5=h5';

            return $settings;
        });
    }

    private function personalized_login_area()
    {
        add_action('login_head', function () {
            echo '<style type="text/css">
                    .login h1 a {
                        background-image: url(' . get_bloginfo('template_directory') . '/resources/assets/img/Favico.png) !important;
                        background-size: contain;
                        margin-bottom: 25px;
                        width: 100%;
                    }
                    #nav > a {
                        display: none;
                    }
                </style>';
        });
    }
}
