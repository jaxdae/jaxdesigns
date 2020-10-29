<?php

namespace Towa\Theme\Theme;

class Cleanup
{
    public function __construct()
    {
        $this->init_actions();
        $this->remove_actions();
        $this->init_filters();
    }

    public function init_actions()
    {
        add_action('init', [$this, 'disable_emojis']);
        add_action('init', [$this, 'stop_loading_wp_embed']);
    }

    public function remove_actions()
    {
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    }

    public function init_filters()
    {
        add_filter('tiny_mce_plugins', [$this, 'disable_emojis_tinymce']);
        add_filter('xmlrpc_enabled', '__return_false');
        add_filter('the_generator', '__return_false');
    }

    public function disable_emojis()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }

    public function disable_emojis_tinymce($plugins)
    {
        return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
    }

    public function stop_loading_wp_embed()
    {
        if (! is_admin()) {
            wp_deregister_script('wp-embed');
        }
    }
}
