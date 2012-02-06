<?php

/**
 * Description of Timeline
 *
 * @author davi
 */
class Lib_Form_Page extends Zend_Form
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

        // Title
        $this->addElement('text', 'title', array(
            'label' => 'Título',
            'class' => 'input-text-02',
            'size' => '60',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options' => array(4)
                ),
            )
        ));

        // Link
        $this->addElement('text', 'url', array(
            'label' => 'Url',
            'class' => 'input-text-02',
            'size' => '60',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options' => array(4)
                ),
            )
        ));

        // Text
        $this->addElement('textarea', 'text', array(
            'label' => 'Texto',
            'rows' => 5,
            'cols' => 70,
            'class' => 'input-text',
            'required' => false,
            'filters' => array('StringTrim')
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
