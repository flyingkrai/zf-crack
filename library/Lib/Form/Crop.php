<?php

/**
 * @author Davi Alves
 */
class Lib_Form_Crop extends Zend_Form
{

    public function init()
    {
        // Config
        $this->setMethod('post');
        $this->clearDecorators();
        $decorators = array(
            'ViewHelper',
            'HtmlTag',
            'Label'
        );

        // Image
        $this->addElement('hidden', 'image', array(
            'required' => true,
            'filters' => array('StringTrim'),
            'decorators' => $decorators
        ));

        // X1
        $this->addElement('hidden', 'x1', array(
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'Int'
                ),
            ),
            'decorators' => $decorators
        ));

        // X2
        $this->addElement('hidden', 'x2', array(
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'Int'
                ),
            ),
            'decorators' => $decorators
        ));

        // Y1
        $this->addElement('hidden', 'y1', array(
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'Int'
                ),
            ),
            'decorators' => $decorators
        ));

        // Y2
        $this->addElement('hidden', 'y2', array(
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'Int'
                ),
            ),
            'decorators' => $decorators
        ));

        // W
        $this->addElement('hidden', 'w', array(
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'Int'
                ),
            ),
            'decorators' => $decorators
        ));

        // H
        $this->addElement('hidden', 'h', array(
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'Int'
                ),
            ),
            'decorators' => $decorators
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
            'salt' => 'crop_form',
            'decorators' => $decorators
        ));
    }

}
