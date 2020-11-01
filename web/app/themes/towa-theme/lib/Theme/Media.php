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
             ['name' => 'i480x480', 'width' => 480, 'height' => 480, 'crop' => true], // Image Phone, Video 
            ['name' => 'i768x432', 'width' => 768, 'height' => 432, 'crop' => true], // Image Tablet, Video Tablet
            ['name' => 'i920x517', 'width' => 920, 'height' => 517, 'crop' => true], // Image Desktop, Video Desktop, DefaultHero Tablet
            ['name' => 'i1440x810', 'width' => 1440, 'height' => 810, 'crop' => true], //DefaultHero Tablet

            // 3:2
                ['name' => 'i1250x833', 'width' => 1250, 'height' => 833, 'crop' => true], // Slider
                ['name' => 'i
                ', 'width' => 930, 'height' => 620, 'crop' => true],
                ['name' => 'i800x533', 'width' => 800, 'height' => 533, 'crop' => true],
                
            // 3:1
            ['name' => 'i920x640', 'width' => 920, 'height' => 640, 'crop' => true], //DefaultHero Desktop
            ['name' => 'i920x920', 'width' => 920, 'height' => 920, 'crop' => true], //DefaultHero Phone

            // 1:1
            ['name' => 'i920x920', 'width' => 920, 'height' => 920, 'crop' => true], //DefaultHero Phone
            ['name' => 'i480x480', 'width' => 480, 'height' => 480, 'crop' => true], //DefaultHero Phone
        ]);

        $this->add_sizes();
        $this->prevent_image_size_creation();
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
}
