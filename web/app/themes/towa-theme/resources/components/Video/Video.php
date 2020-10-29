<?php

namespace Towa\Components\Video;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Oembed;
use Towa\Acf\Fields\Text;

class Video extends BaseSection
{
    public $name = 'Video';

    public $view = 'components/Video/Video.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => 'Video',
            'display' => 'row',
            'sub_fields' => [
                (new Oembed($this->get_key(), 'video_url', 'Video Url'))->build([
                    'required' => true,
                ]),
                (new Image($this->get_key(), 'image', 'Vorschaubild'))->build([
                    'required' => true,
                ]),
                (new Text($this->get_key(), 'caption_bold', 'Untertitel Bold'))->build([
                    'instructions' => __('Optional.', 'towa'),
                ]),
                (new Text($this->get_key(), 'caption', 'Untertitel'))->build([
                    'instructions' => __('Optional.', 'towa'),
                ]),
            ],
        ];
    }
}
