<?php

namespace Towa\Components\Content;

use Towa\Acf\BaseSection;
use Towa\Components\Accordion\Accordion;
use Towa\Components\Blockquote\Blockquote;
use Towa\Components\Downloads\Downloads;
use Towa\Components\Image\Image;
use Towa\Components\Tab\Tab;
use Towa\Components\Video\Video;
use Towa\Components\Wysiwyg\Wysiwyg;

class Content extends BaseSection
{
    public $name = 'Content';

    public $view = 'resources/components/Content/Content.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Inhalt', 'towa'),
            'display' => 'block',
            'sub_fields' => [
                [
                    'key' => $this->name . '_components',
                    'name' => 'content_components',
                    'type' => 'flexible_content',
                    'button_label' => __('Inhalt hinzufügen', 'towa'),
                    'layouts' => $this->get_sections(),
                ],
            ],
        ];
    }

    private function get_sections()
    {
        $Sections = [
            Accordion::class,
            Downloads::class,
            Image::class,
            Tab::class,
            Video::class,
            Wysiwyg::class,
            Blockquote::class,
        ];

        return collect($Sections)->map(function ($Section) {
            return $Section::get_instance('flexible_components_modules_')->get_acf_fields();
        })->toArray();
    }
}
