<?php

namespace SONUser\Form;

use Zend\InputFilter\InputFilter;

/**
 * Class UserFilter
 * @package SONUser\Form
 */
class UserFilter extends InputFilter {

    public function __construct() {
        $this->add(array(
            'name' => 'nome',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Não pode deixar em branco',
                        ),
                    ),
                ),
            ),
        ));

        $validatorEmail = new \Zend\Validator\EmailAddress();
        $validatorEmail->setOptions(array(
            'name' => 'NotEmpty',
            'domain' => false,
            'options' => array(
                'messages' => array(
                    'isEmpty' => 'Não pode deixar em branco',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                $validatorEmail
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Não pode deixar em branco',
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'confirmation',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            ),
        ));
    }

} 