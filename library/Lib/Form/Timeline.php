<?php

/**
 * Description of Timeline
 *
 * @author davi
 */
class Lib_Form_Timeline extends Zend_Form
{

    public function init()
    {
        // Config
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

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
        $this->addElement('text', 'link', array(
            'label' => 'Link',
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

        // Data
        $this->addElement('text', 'date', array(
            'label' => 'Data',
            'class' => 'input-text-02',
            'readonly' => true,
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'Regex',
                    'options' => array(
                        'pattern' => '/^([0-9]{2,2})+\-([0-9]{2,2})+\-([0-9]{4,4})+ ([0-9]{2,2}+:+[0-9]{2,2})$/',
                        'messages' => array(
                            Zend_Validate_Regex::NOT_MATCH => 'Invalid date'
                        )
                    )
                )
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

        // Image
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Imagem')
                ->setRequired(false);
        $image->addValidator('ImageSize', false, array('minheight' => 272, 'minwidth' => 272));
        $image->addValidator('Size', false, 512000);
        $image->addValidator('Count', false, 1);
        $image->addValidator('Extension', false, 'jpg,png,gif');
        $this->addElement($image, 'image');

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
