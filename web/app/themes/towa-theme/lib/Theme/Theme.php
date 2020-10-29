<?php

namespace Towa\Theme\Theme;

use Towa\Theme\Timber\Context;
use Towa\Theme\Timber\Extensions;

class Theme
{
    public function defines()
    {
        define('PATH_THEME', get_template_directory_uri());
        define('PATH_CSS', PATH_THEME . '/dist/css/');
        define('PATH_FONTS', PATH_THEME . '/dist/assets/fonts/');
        define('PATH_IMAGES', PATH_THEME . '/dist/assets/img/');
        define('PATH_JS', PATH_THEME . '/dist/js/');
        define('PATH_COMPONENTS', PATH_THEME . '/dist/components/');
        define('PATH_DIST', PATH_THEME . '/dist/');

        return $this;
    }

    public function settings()
    {
        new Settings();

        return $this;
    }

    public function support()
    {
        new Support();

        return $this;
    }

    public function hooks()
    {
        new Hooks();

        return $this;
    }

    public function assets()
    {
        new Assets();

        return $this;
    }

    public function menues()
    {
        new Menu();

        return $this;
    }

    public function media()
    {
        new Media();

        return $this;
    }

    public function permission()
    {
        new Permission();

        return $this;
    }

    public function cleanup()
    {
        new Cleanup();

        return $this;
    }

    public function timber()
    {
        new Context();
        new Extensions();

        return $this;
    }
}
