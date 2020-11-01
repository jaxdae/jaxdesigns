<?php


namespace Towa\Components\Video;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Oembed;
use Towa\Acf\Fields\TrueFalse;

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
                    'required' => true
                ]),
                (new Image($this->get_key(), 'image', 'Vorschaubild'))->build([
                    'required' => true
                ]),
                (new TrueFalse($this->get_key(), 'do_autoplay', 'Autoplay?'))->build([
                    'ui' => 1,
                ]),
            ],
        ];
    }
}
