<?php

namespace Towa\Theme\Theme;

use Towa\Theme\Extensions\Sectionpreviews\Sectionpreviews as Previews;

class Support
{
    public function __construct()
    {
        $this->add_theme_support_general();
        $this->add_theme_support_posts();
        $this->remove_theme_support();
        $this->cleanup_dashboard();
        $this->cleanup_panel_boxes();
        $this->cleanup_menu();
        $this->cleanup_toolbars();
        $this->custom_footer_text();
        $this->register_sectionpreviews();
        $this->tiny_mce_add_plugins();
    }

    private function add_theme_support_general()
    {
        add_theme_support('html5', ['search-form', 'comment-form', 'comment-list']);
        add_theme_support('plate-permalink', '/%postname%/');
    }

    private function cleanup_dashboard()
    {
        add_theme_support('plate-dashboard', [
            'dashboard_activity',
            'dashboard_incoming_links',
            'dashboard_plugins',
            'dashboard_primary',
            'dashboard_quick_press',
            'dashboard_recent_comments',
            'dashboard_recent_drafts',
            'dashboard_secondary',
            'dashboard_right_now',
        ]);

        add_action('wp_dashboard_setup', function () {
            //remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'side');
        });
    }

    private function cleanup_panel_boxes()
    {
        add_theme_support('plate-editor', [
            'commentsdiv',
            'commentstatusdiv',
            'linkadvanceddiv',
            'linktargetdiv',
            'linkxfndiv',
            'postcustom',
            'postexcerpt',
            'slugdiv',
            'sqpt-meta-tags',
            'trackbacksdiv',
            //            'revisionsdiv',
            //            'categorydiv',
            //            'tagsdiv-post_tag',
        ]);
    }

    private function cleanup_menu()
    {
        $pages = [
            'edit-comments.php', // comments
            'index.php', // dashboard
            'themes.php', // dashboard
        ];

        add_theme_support('plate-menu', $pages);

        if (! current_user_can('administrator')) {
            $pages = array_merge($pages, [
                'edit.php?post_type=acf-field-group', // Custom post type
                'tools.php?page=wp-migrate-db', // Plugin in Tools
                'options-general.php?page=menu_editor', // Plugin in Settings
                'admin.php?page=theseoframework-settings', // Plugin in menu root
            ]);

            add_theme_support('plate-menu', $pages);
        }

        add_action('admin_menu', [$this, 'move_menu_page_to_root']);
    }

    private function cleanup_toolbars()
    {
        add_theme_support('plate-toolbar', [
            'comments',
            'wp-logo',
            'appearance',
            'new-content',
            'updates',
            'search',
        ]);

        add_theme_support('plate-tabs', ['help', 'screen-options']);
    }

    private function custom_footer_text()
    {
        add_theme_support('plate-footer-text', '');
    }

    public function move_menu_page_to_root()
    {
        add_menu_page(__('Menüs', 'towa'), __('Menüs', 'towa'), 'edit_theme_options', 'menues', '', 'dashicons-menu', 69);
        global $menu;
        $menu[69][2] = 'nav-menus.php';
    }

    private function add_theme_support_posts()
    {
        add_action('admin_init', function () {
            add_theme_support('post-thumbnails');
        });
    }

    private function remove_theme_support()
    {
        add_action('admin_init', function () {
            remove_post_type_support('page', 'editor');
            remove_post_type_support('post', 'editor');
        });
    }

    private function register_sectionpreviews()
    {
        add_action('admin_init', function () {
            ( new Previews() )->register_sectionpreviews();
        });
    }

    private function tiny_mce_add_plugins()
    {
        // add aditional external wysiwyg plugins here
        // 1 - add folder/files to lib/Extensions
        // 2 - add naming to $plugins array
        add_filter('mce_external_plugins', function () {
            $plugins = [
                'charcount',
            ];

            $plugins_arr = [];
            foreach ($plugins as $plugin) {
                $plugins_arr[$plugin] = content_url(
                    'themes/towa-theme/lib/Extensions/TinyMCE/' . $plugin . '/' . $plugin . '.min.js'
                );
            }

            return $plugins_arr;
        });
        add_action('admin_head', function () {
            echo '<style>.mce-container .mce-container-body .mce-charcount{font-size:12px;color:#666;float:right;margin-right:20px;}</style>';
        });
    }
}
