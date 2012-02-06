<?php

/**
 * @author Davi Alves
 */
class Lib_View_Helper_FormError extends Zend_View_Helper_Abstract
{
    protected $_erros = array(
        'username' => array(
            'isEmpty' => 'Login obrigatório'
        ),
        'password' => array(
            'isEmpty' => 'Senha obrigatória'
        ),
    );

    public function translateErrors($element, $error)
    {

    }
}
