<?php

/**
 * Description of Menu
 *
 * @author davi
 */
class Lib_Form_Menu extends Zend_Form
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
            array('Description', array('tag' => 'span', 'separator' => '<br/>', 'class' => 'smaller low')),
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
            'label' => 'Título *',
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

        // Ordem
        $this->addElement('text', 'order', array(
            'label' => 'Ordem *',
            'class' => 'input-text',
            'description' => 'Ordem de exibição',
            'size' => '2',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array('Digits')
        ));

        // Link
        $this->addElement('text', 'link', array(
            'label' => 'Link',
            'class' => 'input-text-02',
            'description' => 'Use esse campo para links externos',
            'size' => '40',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options' => array(4)
                ),
            )
        ));

        // Páginas
        $options = $this->_getOptions();
        $this->addElement('select', 'page_id', array(
            'label' => 'Página',
            'class' => 'input-text',
            'style' => 'width:200px',
            'description' => 'Use esse campo fazer referência a uma página do sistema',
            'multiOptions' => $options,
            'required' => false,
            'filters' => array('StringTrim')
        ));

        // Target
        $this->addElement('select', 'target', array(
            'label' => 'Target',
            'class' => 'input-text',
            'multiOptions' => array(
                '_self' => '_self',
                '_blank' => '_blank',
                '_parent' => '_parent'
            ),
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

    protected function _getOptions()
    {
        $model = new Application_Model_Page();

        $pages = $model->findAll();
        $pages = (!$pages) ? array() : $pages;

        $options = array(
            0 => 'Selecione'
        );
        foreach ($pages as $page) {
            $options[$page->id] = $this->_trimTitle($page->title);
        }

        return $options;
    }

    protected function _trimTitle($title, $length = 20)
    {
        if (strlen($title) < $length) {
            return $title;
        }

        return substr($title, 0, $length) . '...';
    }

}
