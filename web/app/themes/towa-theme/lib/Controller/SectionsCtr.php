<?php

namespace Towa\Theme\Controller;

use Towa\Theme\Theme\Media;
use Timber;

class SectionsCtr
{
    public static $counter = 0;
    private $post;
    private $sections;

    public function __construct($post, $is_term = false)
    {
        $this->post = $post;
        $this->sections = collect($this->fetch_sections($is_term));
    }

    private function fetch_sections($is_term = false)
    {
        return $is_term ? get_field('sections', $this->post) : $this->post->get_field('sections');
    }

    public function build()
    {
        $this->sections = $this->sections->map(function ($section) {
            if (false === $section) {
                return [];
            }

            $method_name = str_replace('-', '_', $section['acf_fc_layout']);

            if (method_exists($this, $method_name)) {
                $section = $this->$method_name($section);
            }

            $section['counter'] = self::$counter++;
            $section['view'] = $this->determine_view($section);

            return $section;
        })->filter();

        return $this->sections->isNotEmpty() ? $this->sections->toArray() : [];
    }

    private function determine_view($section)
    {
        return $section['template'] ?? 'resources/components/' . $section['acf_fc_layout'] . '/' . $section['acf_fc_layout'] . '.twig';
    }

    private function Slider($section)
    {
        $component_options = [
            'breakpoints' => Media::$breakpoints,
        ];

        $section['component'] = [
            'name' => 'Slider',
            'props' => htmlentities(json_encode($component_options), ENT_QUOTES, 'UTF-8'),
        ];

        return $section;
    }
    private function HomeSlider($section)
    {
        $component_options = [
            'breakpoints' => Media::$breakpoints,
        ];

        $section['featured'] = collect($section['featured'])->map(function ($item, $key) {
            $item->image = get_field('image', $item->ID);
            return $item;
        })->toArray();
        return $section;
    }

    private function Content($section)
    {
        $section['content_components'] = collect($section['content_components'])->map(function ($section) {
            $method_name = str_replace('-', '_', $section['acf_fc_layout']);

            if (method_exists($this, $method_name)) {
                $section = $this->$method_name($section);
            }

            $section['counter'] = self::$counter++;
            $section['view'] = $this->determine_view($section);

            return $section;
        })->toArray();

        return $section;
    }

     private function PostGrid($module)
    {     
        $args = array(
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'posts_per_page'   => -1,
        );

        $module['posts'] = collect(Timber::get_posts( $args ))->map(function ($item, $key) {
            $item->image = get_field('image', $item->ID);           
            return $item;
        })->toArray();
         unset($module['posts'][0]);
        return $module;
    }

    private function Video($module)
    {
        $module['video_id'] = false;

        // gets youtube id and saves it into video_id
        preg_match(
            '/embed\/([\w+\-+]+)[\"\?]/',
            $module['video_url'],
            $module['video_id']
        );
        // preg_match returns array, we need the correct entry
        // 0 - embed/my_video_id
        // 1 - my_video_id
        if (count($module['video_id']) > 1) {
            $module['video_id'] = $module['video_id'][1];
        }

        return $module;
    }

    private function Blockquote($module)
    {
        $module['meta'] = $module['name'];
        if ($module['position']) {
            $module['meta'] .= ', ' . $module['position'];
        }

        return $module;
    }

    private function Downloads($module)
    {
        $module['items'] = collect($module['items'])->map(function ($item) {
            return $item->get_list_data();
        })->toArray();

        return $module;
    }

    // - - -
    // static functions

    public static function get_image($post)
    {
        return $post->get_field('image');
    }


}
