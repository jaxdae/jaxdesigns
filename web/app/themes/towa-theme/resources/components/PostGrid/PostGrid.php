<?php

namespace Towa\Components\PostGrid;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Text;
use Towa\Acf\Fields\TextArea;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Wysiwyg;
use Towa\Acf\Fields\Repeater;
use Towa\Acf\Fields\Relation;

class PostGrid extends BaseSection
{
    public $name = 'PostGrid';
    public $view = 'resources/components/PostGrid/PostGrid.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Post Grid', 'towa'),
            'display' => 'block',
            'sub_fields' => [
                ( new Relation($this->get_key(), 'posts', 'Posts') )->build([
                   'conditional_logic' => 0,
			'post_type' => array(
                0 => 'post',
                1 => 'page'
			),
			'filters' => array(
				0 => 'search',
				1 => 'post_type',
			),
               ]),
            ],
        ];
    }
}
