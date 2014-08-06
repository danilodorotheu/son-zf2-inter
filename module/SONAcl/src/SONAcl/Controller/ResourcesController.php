<?php

namespace SONAcl\Controller;

use SONBase\Controller\CrudController;

/**
 * Class ResourcesController
 * @package SONAcl\Controller
 */
class ResourcesController extends CrudController {

    public function __construct() {
        $this->service = "SONAcl\Service\Resource";
        $this->entity = 'SONAcl\Entity\Resource';
        $this->form = 'SONAcl\Form\Resource';
        $this->route = 'sonacl-admin/default';
        $this->controller = 'resources';
    }

} 