<?php
namespace Towa\Components\Blockquote;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Text;
use Towa\Acf\Fields\Textarea;

class Blockquote extends BaseSection
{
    public $name = 'Blockquote';

    public $view = 'components/Blockquote/Blockquote.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Zitat', 'towa'),
            'display' => 'block',
            'sub_fields' => [
                ( new Textarea($this->get_key(), 'text', 'Text'))->build([
                    'required' => true,
                    'rows' => 3,
                ]),
                ( new Text($this->get_key(), 'name', 'Name'))->build([
                    'required' => true,
                    'wrapper' => ['width' => 60],
                ]),
                ( new Text($this->get_key(), 'position', 'Position'))->build([
                    'wrapper' => ['width' => 40],
                ]),
            ],
        ];
    }
}
