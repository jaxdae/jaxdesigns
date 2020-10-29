<?php

namespace Towa\Theme\Theme;

class Permission
{
    public function __construct()
    {
        $this->hide_menues_for_non_admins();
    }

    private function hide_menues_for_non_admins()
    {
        if (current_user_can('administrator')) {
            return;
        }

        add_action('admin_head', function () {
            global $submenu;
            $customizer_site = false;

            if (is_array($submenu) && isset($submenu['themes.php'])) {
                $customizer_site = array_values(array_filter($submenu['themes.php'], function ($page) {
                    return ('customize' == $page[1]);
                }));
            }

            // index 2 is the menu-slug
            if (is_array($customizer_site)) {
                remove_submenu_page('themes.php', $customizer_site[0][2]);
            }

            remove_submenu_page('themes.php', 'themes.php');
            remove_submenu_page('themes.php', 'widgets.php');
            remove_submenu_page('themes.php', 'theme-editor.php');
            remove_submenu_page('themes.php', 'tools.php');

            remove_menu_page('wpcf7');
        });
    }
}
