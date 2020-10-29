<?php

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Towa\Theme\Cpt\Download;
use Towa\Theme\Cpt\Page;
use Towa\Theme\Cpt\Post;

if (! function_exists('get_cpt_classmap')) {
    /**
     * build cpt classmap for queryiterator in timber
     *
     * @return array
     */
    function get_cpt_classmap()
    {
        return [
            Page::NAME => Page::class,
            Post::NAME => Post::class,
            Download::NAME => Download::class,
        ];
    }
}

if (! function_exists('get_stage')) {
    function get_stage()
    {
        return env('WP_ENV');
    }
}

if (! function_exists('is_development_stage')) {
    function is_development_stage()
    {
        return ('development' === get_stage());
    }
}

if (! function_exists('is_test_stage')) {
    function is_test_stage()
    {
        return ('test' === get_stage());
    }
}

if (! function_exists('is_production_stage')) {
    function is_production_stage()
    {
        return ('production' === get_stage());
    }
}

if (! function_exists('view_path')) {
    function view_path($to)
    {
        return sprintf('views/%1$s', $to);
    }
}

if (! function_exists('register_style')) {
    function register_style($name)
    {
        wp_enqueue_style(
            $name,
            PATH_COMPONENTS . $name . '/' . $name . '.css',
            ['towa-main-style'],
            theme_version()
        );
    }
}

if (! function_exists('theme_version')) {
    function theme_version()
    {
        $theme = wp_get_theme();

        return $theme->get('Version');
    }
}

if (! function_exists('mix')) {
    /**
     * Get the path to a versioned Mix file.
     *
     * @param  string  $path
     * @param  string  $manifestDirectory
     * @return \Illuminate\Support\HtmlString|string
     *
     * @throws \Exception
     */
    function mix($path, $manifestDirectory = '')
    {
        static $manifests = [];

        if (! Str::startsWith($path, '/')) {
            $path = "/{$path}";
        }

        if ($manifestDirectory && ! Str::startsWith($manifestDirectory, '/')) {
            $manifestDirectory = "/{$manifestDirectory}";
        }

        if (file_exists(public_path($manifestDirectory.'/hot'))) {
            $url = rtrim(file_get_contents(public_path($manifestDirectory.'/hot')));

            if (Str::startsWith($url, ['http://', 'https://'])) {
                return new HtmlString(Str::after($url, ':').$path);
            }

            return new HtmlString("//localhost:8080{$path}");
        }

        $manifestPath = public_path($manifestDirectory.'/mix-manifest.json');

        if (! isset($manifests[$manifestPath])) {
            if (! file_exists($manifestPath)) {
                throw new \Exception('The Mix manifest does not exist.');
            }

            $manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
        }

        $manifest = $manifests[$manifestPath];

        if (! isset($manifest[$path])) {
            throw new \Exception("Unable to locate Mix file: {$path}.");

            if (! defined('WP_DEBUG') || WP_DEBUG === false) {
                return $path;
            }
        }

        return rtrim(PATH_DIST, '/').(new HtmlString($manifestDirectory.$manifest[$path]))->toHtml();
    }
}

if (! function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string  $path
     * @return string
     */
    function public_path($path = '')
    {
        return get_template_directory().'/dist'.($path ? DIRECTORY_SEPARATOR.ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}

if (! function_exists('get_video_id')) {
    /**
     * extract the id of a video url
     *
     * @param string $video_url
     * @return string|bool
     */
    function get_video_id($video_url)
    {
        $youtube_regex = '/^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/';

        $foundMatches = preg_match($youtube_regex, $video_url, $matches);

        if ($foundMatches === 1) {
            return $matches[1];
        }

        return false;
    }
}
