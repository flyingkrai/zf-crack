<?php

/**
 * Description of Log
 *
 * @author davi
 */
class Lib_View_Helper_Log
{

    protected $_translate = array(
        'title' => 'Título',
        'content' => 'Texto',
        'sequence' => 'Ordem',
        'created' => 'Criado',
        'updated' => 'Atualizado',
        'image' => 'Imagem',
        'date' => 'Data',
        'name' => 'Nome',
        'username' => 'Login',
        'password' => 'Senha',
    );

    /**
     * @param mixed|array $data 
     */
    public function dumpLogData($data)
    {
        if (!$data) {
            return null;
        }
        $data = unserialize($data);
        $output = null;

        if (is_array($data)) {
            ksort($data);
            ob_start();
            print '<pre>';
            foreach ($data as $key => $row) {
                $correctKey = $key;
                if (array_key_exists($key, $this->_translate)) {
                    $correctKey = $this->_translate[$key];
                }
                $correctKey = ucfirst($correctKey);
                $text = (strlen($row) > 60) ? substr($row, 0, 60) . '...' : $row;

                print "    $correctKey  <font color='#888a85'>=></font> <font color='#cc0000'>'$text'</font>\n";
            }
            $output = ob_get_clean();
        } else {
            $output = $data;
        }

        return $output;
    }

}
