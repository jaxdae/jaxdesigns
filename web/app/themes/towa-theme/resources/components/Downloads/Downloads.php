<?php

namespace Towa\Components\Downloads;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Relation;
use Towa\Theme\Cpt\Download as CptDownload;

class Downloads extends BaseSection
{
    public $name = 'Downloads';

    public $view = 'resources/components/Downloads/Downloads.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Downloads', 'towa'),
            'display' => 'block',
            'sub_fields' => [
                (new Relation($this->get_key(), 'items', 'Downloads'))->build([
                    'post_type' => CptDownload::NAME,
                ]),
            ],
        ];
    }
}
