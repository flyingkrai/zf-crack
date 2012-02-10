<?php

/**
 * @author Davi Alves
 */
class Lib_Extra_Image extends Lib_Extra_Source_ImageLib
{

    public function resizeImage($image, $width = 272, $height = 272)
    {
        if (empty($image)) {
            return '';
        }

        $path = UPLOAD_PATH;
        $img = explode('.', $image);

        $banner_resized = $img[0] . '_' . $width . 'x' . $height . '.' . $img[1];

        if (!file_exists($path . $banner_resized)) {
            $config['image_library'] = 'gd2';
            $config['source_image'] = $path . $image;
            $config['thumb_marker'] = '_' . $width . 'x' . $height;
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $width;
            $config['height'] = $height;

            $this->clear();
            $this->initialize($config);
            if (!$this->resize()) {
                return $this->display_errors();
            }
        }
        @chmod($path . $banner_resized, 0777);

        return UPLOAD_URL . $banner_resized;
    }

}
