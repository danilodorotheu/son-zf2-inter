<?php

namespace SONUser\Controller;

/**
 * Class UsersController
 *
 * @package SONUser\Controller
 */
class UsersController extends CrudController {

    public function __construct() {
        $this->service = 'SONUser\Service\User';
        $this->entity = 'SONUser\Entity\User';
        $this->form = 'SONUser\Form\User';
        $this->route = 'sonuser-admin';
        $this->controller = 'users';
    }

} 