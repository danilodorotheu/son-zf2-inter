<?php

namespace SONUser\Form;

use Zend\Form\Form;

/**
 * Class Login
 * @package SONUser\Form
 */
class Login extends Form {

    /**
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = array()) {
        parent::__construct('user', $options);
        $this->setAttribute('method', 'post');

        $email = new \Zend\Form\Element\Email('email');
        $email->setLabel('Email: ')
            ->setAttribute('placeholder', 'Entre com o email');
        $this->add($email);

        $password = new \Zend\Form\Element\Password('password');
        $password->setLabel('Senha: ')
            ->setAttribute('placeholder', 'Entre com a senha');
        $this->add($password);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Entrar',
                'class' => 'btn-success'
            ),
        ));
    }

} 