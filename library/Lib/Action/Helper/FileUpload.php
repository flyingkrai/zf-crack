<?php

/**
 * Description of Upload
 *
 * @author davi
 */
class Lib_Action_Helper_FileUpload extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * @param string $dir
     * @return string|boolean
     */
    public function getFilePath($dir = null)
    {
        $filePath = ($dir) ? UPLOAD_PATH . "/$dir" : UPLOAD_PATH;
        $date = new DateTime(date('Y-m-d H:i'), new DateTimeZone('America/Fortaleza'));
        $date = $date->format('d-m-Y');
        list($day, $month, $year) = explode('-', $date);
        $filePath = $this->create($filePath, array($year, $month, $day));

        return $filePath;
    }

    /**
     * @param string $fileType
     * @return string
     */
    public function generateFileName($fileType)
    {
        return time() . uniqid() . ".$fileType";
    }

    protected function create($base, $subdirs)
    {
        if (!is_dir($base)) {
            mkdir($base, 0777);
        }

        foreach ($subdirs as $dir) {
            $base .= "/$dir";
            if (!is_dir($base)) {
                mkdir($base, 0777);
            }
        }

        return $base;
    }

    public function direct($dir = null)
    {
        return $this->getFilePath($dir);
    }

}
