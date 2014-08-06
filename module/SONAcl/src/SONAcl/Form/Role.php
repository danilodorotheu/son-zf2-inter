<?php

namespace SONAcl\Form;

use Zend\Form\Form,
    Zend\Form\Element\Select,
    Zend\Form\Element\Checkbox;

/**
 * Class Role
 * @package SONAcl\Form
 */
class Role extends Form {

    protected $parent;

    public function __construct($name = null, array $parent) {
        parent::__construct($name);
        $this->parent = $parent;

        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $nome = new \Zend\Form\Element\Text('nome');
        $nome->setLabel('Nome: ')
            ->setAttribute('placeholder', 'Entre com o nome');
        $this->add($nome);

        $allParent = array_merge(array(0 => 'Nenhum'), $this->parent);
        $parent = new Select();
        $parent->setLabel('Herda: ')
            ->setName('parent')
            ->setOptions(array('value_options' => $allParent));
        $this->add($parent);

        $isAdmin = new Checkbox('isAdmin');
        $isAdmin->setLabel('Admin?: ');
        $this->add($isAdmin);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn-success'
            ),
        ));
    }

} 