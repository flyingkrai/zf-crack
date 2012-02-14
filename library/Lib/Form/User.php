<?php

/**
 * @author Davi Alves
 */
class Lib_Form_User extends Zend_Form
{

    public function init()
    {
        // Config
        $this->setMethod('post');

        // Decorators
        $this->clearDecorators();
        $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('separator' => '<br/>', 'class' => 'req')),
            array('HtmlTag', array('tag' => 'p')),
        ));


        // Id
        $this->addElement('hidden', 'id', array(
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'Int'
                ),
            )
        ));

        // Nome
        $this->addElement('text', 'name', array(
            'label' => 'Nome *',
            'class' => 'input-text-02',
            'size' => '60',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options' => array(4)
                )
            )
        ));

        // Email
        $this->addElement('text', 'email', array(
            'label' => 'Email *',
            'class' => 'input-text-02',
            'size' => '60',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options' => array(4)
                ),
                'EmailAddress'
            )
        ));

        // Role
        $this->addElement('select', 'role', array(
            'label' => 'Nível de acesso',
            'class' => 'input-text',
            'multiOptions' => array(
                'admin' => 'Admin',
                'colaborador' => 'Colaborador',
                'editor' => 'Editor',
                'usuario' => 'Usuário'
            ),
            'required' => false,
            'filters' => array('StringTrim', 'StringToLower')
        ));

        // Login
        $this->addElement('text', 'username', array(
            'label' => 'Login *',
            'class' => 'input-text-02',
            'size' => '60',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options' => array(4, 10)
                )
            )
        ));
        
        $passValidation = new Lib_Form_Validate_PasswordConfirmation();
        // Password
        $this->addElement('password', 'password', array(
            'label' => 'Senha *',
            'class' => 'input-text-02',
            'size' => '60',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options' => array(4)
                ),
                $passValidation
            )
        ));

        // Confirm Password
        $this->addElement('password', 'password_confirm', array(
            'label' => 'Confirmação *',
            'class' => 'input-text-02',
            'size' => '60',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options' => array(4)
                ),
                $passValidation
            )
        ));

        // Submit
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Salvar',
            'class' => 'input-submit'
        ));

        // CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
            'salt' => 'user_form',
        ));
    }

}
