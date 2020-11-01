<?php

namespace Towa\Components\Image;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Image as FImage;

/**
 * Class Image
 */
class Image extends BaseSection
{
    public $name = 'Image';
    public $view = 'components/Image/Image.twig';
    private $key;

    /**
     *
     * Returns the fields
     *
     * @param string $prefix
     *
     * @return array of acf
     */
    public function get_acf_fields($prefix = '')
    {

        // $this->set_key( $prefix . self::$name );

        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => 'Bild',
            'display' => 'row',
            'sub_fields' => [
                (new FImage($this->get_key(), 'image', 'Bild'))->build([
                    'required' => true,
                ])
            ],
        ];
    }
}
