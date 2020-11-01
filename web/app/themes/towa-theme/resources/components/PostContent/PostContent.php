<?php

namespace Towa\Components\PostContent;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Text;
use Towa\Acf\Fields\TextArea;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Wysiwyg;
use Towa\Acf\Fields\Repeater;
use Towa\Acf\Fields\Relation;
use Towa\Acf\Fields\Select;


class PostContent extends BaseSection
{
    public $name = 'PostContent';
    public $view = 'resources/components/PostContent/PostContent.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Header', 'towa'),
            'display' => 'block',
            'sub_fields' => [
                (new Text($this->get_key(), 'title', 'Titel'))->build([
                    'required' => true,
                ]),
                   (new Image($this->get_key(), 'image', 'Highlight Bild'))->build([
                    'required' => true,
                ]),
                (new Select($this->get_key(), 'category', 'Kategorie'))->build([
	                'choices' => array(
				'Furniture & Co.' => 'Furniture & Co.',
				'Sewing' => 'Sewing',
				'Decorations' => 'Decorations',
				'Bullet Journal' => 'Bullet Journal',
                'Wood working' => 'Wood working',
                'Jaxdesigns' => 'Jaxdesigns'
			),
                ]),
                 (new Select($this->get_key(), 'difficulty', 'Schwierigkeit'))->build([
	                'choices' => array(
				'Easy' => 'Easy',
				'Intermediate' => 'Intermediate',
				'Difficult' => 'Difficult'
			),
                ]),
            ],
        ];
    }
}
