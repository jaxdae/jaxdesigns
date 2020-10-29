<?php

namespace Towa\Theme\Controller;

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

    private function Video($module)
    {
        $module['video_id'] = get_video_id($module['video_url']);

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
            return $item->transform();
        })->toArray();

        return $module;
    }

    // - - -
    // static functions

    public static function get_hero($post)
    {
        return [
            'title' => $post->get_field('title') ?: $post->title,
            'subtitle' => $post->subtitle ?: false,
            'image' => $post->get_field('image'),
        ];
    }
}
