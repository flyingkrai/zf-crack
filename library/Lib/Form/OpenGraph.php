<?php

/**
 * @author Davi Alves
 */
class Lib_Form_OpenGraph extends Zend_Form
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


        // Title
        $this->addElement('text', 'title', array(
            'label' => 'Title',
            'class' => 'input-text',
            'size' => '40',
            'required' => false,
            'filters' => array('StringTrim'),
        ));
        // Type
        $this->addElement('text', 'type', array(
            'label' => 'Type',
            'class' => 'input-text',
            'size' => '40',
            'required' => false,
            'filters' => array('StringTrim'),
        ));
        // Url
        $this->addElement('text', 'url', array(
            'label' => 'Url',
            'class' => 'input-text',
            'size' => '40',
            'required' => false,
            'filters' => array('StringTrim'),
        ));
        // Image
        $this->addElement('text', 'image', array(
            'label' => 'Image',
            'class' => 'input-text',
            'size' => '40',
            'required' => false,
            'filters' => array('StringTrim'),
        ));
        // Site Name
        $this->addElement('text', 'siteName', array(
            'label' => 'Site Name',
            'class' => 'input-text',
            'size' => '40',
            'required' => false,
            'filters' => array('StringTrim'),
        ));
        // Description
        $this->addElement('textarea', 'description', array(
            'label' => 'Description',
            'class' => 'input-text',
            'rows' => '40',
            'rows' => '4',
            'required' => false,
            'filters' => array('StringTrim'),
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
