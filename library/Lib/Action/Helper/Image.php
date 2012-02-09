<?php

/*
 * File: SimpleImage.php
 * Author: Simon Jarvis
 * Copyright: 2006 Simon Jarvis
 * Date: 08/11/06
 * Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
 * 
 * This program is free software; you can redistribute it and/or 
 * modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
 * GNU General Public License for more details: 
 * http://www.gnu.org/licenses/gpl.html
 *
 */

class Lib_Action_Helper_Image extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * @param string $filePath 
     */
    protected function load($filePath)
    {
        $image = null;
        $image_info = getimagesize($filePath);
        $image_type = $image_info[2];
        if ($image_type == IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($filePath);
        } elseif ($image_type == IMAGETYPE_GIF) {
            $image = imagecreatefromgif($filePath);
        } elseif ($image_type == IMAGETYPE_PNG) {
            $image = imagecreatefrompng($filePath);
        }

        $result = new stdClass();
        $result->resource = $image;
        $result->image_type = $image_type;
        $result->image_path = $filePath;

        return $result;
    }

    /**
     * @param string $filename
     * @param string $permissions
     * @param int $compression 
     */
    protected function save(&$image, $permissions=null, $compression=75)
    {
        if ($image->image_type == IMAGETYPE_JPEG) {
            imagejpeg($image->resource, $image->image_path, $compression);
        } elseif ($image->image_type == IMAGETYPE_GIF) {
            imagegif($image->resource, $image->image_path);
        } elseif ($image->image_type == IMAGETYPE_PNG) {
            imagepng($image->resource, $image->image_path);
        }
        if ($permissions != null) {
            chmod($image->image_path, $permissions);
        }
    }

    /**
     * @param int $image_type 
     */
    public function output($image_type=IMAGETYPE_JPEG)
    {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
    }

    /**
     * @return int 
     */
    public function getWidth()
    {
        return imagesx($this->image);
    }

    /**
     * @return int 
     */
    public function getHeight()
    {
        return imagesy($this->image);
    }

    /**
     * @param int $height 
     */
    public function resizeToHeight($height)
    {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    /**
     * @param int $width 
     */
    public function resizeToWidth($width)
    {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }

    /**
     * @param int $scale 
     */
    public function scale($scale)
    {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    /**
     * @param int $width
     * @param int $height
     * @param int $x_o
     * @param int $y_o
     * @param int $x_d
     * @param int $y_d 
     */
    public function resize($width, $height, $x_o=0, $y_o=0, $x_d=0, $y_d=0)
    {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, $x_d, $y_d, $x_o, $y_o, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }

    /**
     * @param int $width
     * @param int $height
     * @param int $x_o
     * @param int $y_o
     * @param int $x_d
     * @param int $y_d 
     */
    public function cropImg($filePath, $width, $height, $x1=0, $x2=0, $y1=0, $y2=0)
    {
        $image = $this->load($filePath);

        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $image->resource, 0, 0, $x2, $y2, $width, $height, $width, $height);

        $this->save($image, 0777);
    }

}