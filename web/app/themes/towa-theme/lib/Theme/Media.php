<?php

namespace Towa\Theme\Theme;

class Media
{
    public static $breakpoints = [
        'min-width' => '320px',
        'xs' => '480px',
        'sm' => '768px',
        'md' => '1024px',
        'lg' => '1280px',
        'xl' => '1440px',
        'max-width' => '1680px',
    ];

    private $sizes;

    public function __construct()
    {
        $this->sizes = collect([
            // 16:9
            ['name' => 'i480x270', 'width' => 480, 'height' => 270, 'crop' => true], // Image Phone, Video Phone
            ['name' => 'i768x432', 'width' => 768, 'height' => 432, 'crop' => true], // Image Tablet, Video Tablet
            ['name' => 'i920x517', 'width' => 920, 'height' => 517, 'crop' => true], // Image Desktop, Video Desktop, DefaultHero Tablet
            ['name' => 'i1440x810', 'width' => 1440, 'height' => 810, 'crop' => true], //DefaultHero Tablet

            // 3:1
            ['name' => 'i1920x640', 'width' => 1920, 'height' => 640, 'crop' => true], //DefaultHero Desktop

            // 1:1
            ['name' => 'i480x480', 'width' => 480, 'height' => 480, 'crop' => true], //DefaultHero Phone
        ]);

        $this->add_sizes();
        $this->prevent_image_size_creation();
        add_filter('image_size_names_choose', [$this, 'readable_image_sizes']);
    }

    private function add_sizes()
    {
        $this->sizes->each(function ($size) {
            add_image_size($size['name'], $size['width'], $size['height'], $size['crop']);
        });
    }

    private function prevent_image_size_creation()
    {
        add_filter('intermediate_image_sizes_advanced', function ($sizes) {
            unset($sizes['medium']);
            unset($sizes['large']);
            unset($sizes['medium_large']);

            return $sizes;
        });
    }

    public function readable_image_sizes($sizes)
    {
        // 16:9
        $sizes['i480x270'] = 'Image Phone, Video Phone';
        $sizes['i768x432'] = 'Image Tablet, Video Tablet';
        $sizes['i920x517'] = 'Image Desktop, Video Desktop, DefaultHero Tablet';
        $sizes['i1440x810'] = 'DefaultHero Tablet';

        // 3:1
        $sizes['i1920x640'] = 'DefaultHero Desktop';

        // 1:1
        $sizes['i480x480'] = 'DefaultHero Phone';

        return $sizes;
    }
}
