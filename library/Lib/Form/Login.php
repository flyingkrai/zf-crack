<?php

/**
 * @author Davi Alves
 */
class Lib_Form_Login extends Zend_Form
{
    public function init()
    {
        // Config
        $this->setMethod('post');

        $lengthValidator = new Zend_Validate_StringLength();
        $lengthValidator->setMin(4);
        $lengthValidator->setMax(10);
        $lengthValidator->setMessage('Login inválido');

        // Username
        $userNotEmpty = new Zend_Validate_NotEmpty();
        $userNotEmpty->setMessage('Login obrigatório');
        $this->addElement('text', 'username', array(
            'label' => 'Login:',
            'class' => 'input-text',
            'size' => '40',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array($lengthValidator, $userNotEmpty)
        ));


        // Password
        $lengthValidator->setMessage('Senha inválida');
        $passNotEmpty = new Zend_Validate_NotEmpty();
        $passNotEmpty->setMessage('Senha obrigatória');
        $this->addElement('password', 'password', array(
            'label' => 'Senha:',
            'class' => 'input-text',
            'size' => '40',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array($lengthValidator, $passNotEmpty)
        ));

        // Submit
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Entrar',
            'class' => 'input-submit'
        ));

        // CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
            'salt' => 'user_form',
        ));
    }
}
