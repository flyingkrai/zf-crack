<?php

/**
 * Description of Truncate
 *
 * @author davi
 */
class Lib_View_Helper_Text
{

    /**
     * @param string $string
     * @param int $length
     * @return string
     */
    public function truncate($string, $length = 140)
    {
        if (strlen($string) > $length) {
            return htmlspecialchars(substr($string, 0, $length)) . '...';
        }

        return $string;
    }

    public function dbActions($action)
    {
        $result = null;
        switch (strtolower($action)) {
            case 'insert':
                $result = "Cadastrou";
                break;
            case 'update':
                $result = "Atualizou";
                break;
            case 'delete':
                $result = "Deletou";
                break;
            case 'generate':
                $result = "Gerou";
                break;
        }

        return $result;
    }

}
