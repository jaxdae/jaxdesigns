<?php

namespace Towa\Theme\Acf\Groups;

use Towa\Acf\Fields\Tab;
use Towa\Acf\Fields\Wysiwyg;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Link;

class WSOptions
{
    private $prefix = 'website_options';
    private $name = 'website_options';

    public function __construct($prefix = '')
    {
        if (! empty($prefix)) {
            $this->prefix = $prefix;
        }
    }

    public function register()
    {
        acf_add_local_field_group([
            'key' => $this->name,
            'title' => 'Website Optionen',
            'fields' => [
                (new Tab($this->prefix, 'tab_general', 'Allgemein'))->build(),
                (new Image($this->prefix, 'logo', 'Logo'))->build(),
                (new Link($this->prefix, 'home', 'Home'))->build(),
                (new Link($this->prefix, 'imprint', 'Impressum'))->build(),
                (new Link($this->prefix, 'contact', 'Kontakt'))->build(),
                (new Link($this->prefix, 'privacy', 'Datenschutzerklärung'))->build(),
                (new Link($this->prefix, 'about', 'About'))->build(),
                (new Link($this->prefix, 'portfolio', 'Portfolio'))->build(),
                (new Image($this->prefix, 'commentimage', 'Kommentar Bild'))->build(),
                 



                (new Tab($this->prefix, 'tab_contact', 'Kontaktdaten'))->build(),
                // add your options here

                (new Tab($this->prefix, 'tab_social', 'Social Profiles'))->build(),
                // add your options here

                (new Tab($this->prefix, 'tab_404', '404 Settings'))->build(),
                (new Wysiwyg($this->prefix, '404_content', 'Inhalt'))->build([
                    'tabs' => 'visual', 'toolbar' => 'basic',
                ]),
            ],
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-general-settings',
                    ],
                ],
            ],
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => [],
            'active' => 1,
            'description' => '',
        ]);
    }
}
