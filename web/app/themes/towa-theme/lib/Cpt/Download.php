<?php

namespace Towa\Theme\Cpt;

class Download extends TowaPost
{
    const NAME = 'dlm_download';
    const TAX_NAME = 'dlm_download_category';

    public $file;
    public $exists;

    public function __construct($pid = null)
    {
        parent::__construct($pid);

        try {
            $this->file = download_monitor()->service('download_repository')->retrieve_single($this->id);
            // check if file exists, other options return false positive
            // e.g. $this-download->exists() return true, cause post with type exits
            $this->exists = $this->file->get_version()->get_filetype() ? true : false;
        } catch (Exception $exception) {
            // no download with the ID found
            $this->file = false;
            $this->exists = false;
        }

        // if ($this->exists) {
        //     dd();
        //     // dump($this->download->get_version());
        //     // dd(get_class_methods($this->download));
        //     // $this->download->set_version($this->download->get_file_version_ids()[0]);
        // }
    }

    public function transform()
    {
        return [
            'id' => $this->id,
            'title' => $this->post_title,
            'teaser_image' => $this->teaser_image(),
            'teaser_text' => $this->teaser_text(),
            'teaser_text_short' => $this->teaser_text_short(),
            'link' => $this->download_link(),
            'post_type' => $this->post_type,
            'issu' => $this->fetch_field('issu'),
            'exists' => $this->exists(),
            'orderable' => (bool)$this->fetch_field('orderable'),
            'downloadable' => (bool)$this->fetch_field('downloadable'),
        ];
    }

    public function get_list_data()
    {
        return [
            'exists' => $this->exists,
            'title' => $this->file->get_title(),
            'link' => $this->file->get_the_download_link(),
            'size' => $this->file->get_the_filesize(),
            'type' => $this->file->get_version()->get_filetype(),
            'version' => $this->file->get_version()->get_version_number() ?: '1',
        ];
    }

    public function download_link()
    {
        return $this->exists ? $this->download->get_the_download_link() : false;
    }
}
