<?php

namespace SONUser\Form;

use Zend\Form\Form;

/**
 * Class User
 * @package SONUser\Form
 */
class User extends Form {

    /**
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = array()) {

        $this->setInputFilter(new UserFilter());

        parent::__construct('user', $options);
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $nome = new \Zend\Form\Element\Text('nome');
        $nome->setLabel('Nome: ')
            ->setAttribute('placeholder', 'Entre com o nome');
        $this->add($nome);

        $email = new \Zend\Form\Element\Email('email');
        $email->setLabel('Email: ')
            ->setAttribute('placeholder', 'Entre com o email');
        $this->add($email);

        $password = new \Zend\Form\Element\Password('password');
        $password->setLabel('Senha: ')
            ->setAttribute('placeholder', 'Entre com a senha');
        $this->add($password);

        $confirmation = new \Zend\Form\Element\Password('confirmation');
        $confirmation->setLabel('Redigite sua Senha: ')
            ->setAttribute('placeholder', 'Redigite a senha');
        $this->add($confirmation);

        $csrf = new \Zend\Form\Element\Csrf("security");
        $this->add($csrf);

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