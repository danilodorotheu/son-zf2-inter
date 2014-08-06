<?php

namespace SONAcl\Controller;

use Zend\View\Model\ViewModel;

use SONBase\Controller\CrudController;

/**
 * Class RolesController
 * @package SONAcl\Controller
 */
class RolesController extends CrudController {

    public function __construct() {
        $this->service = "SONAcl\Service\Role";
        $this->entity = 'SONAcl\Entity\Role';
        $this->form = 'SONAcl\Form\Role';
        $this->route = 'sonacl-admin/default';
        $this->controller = 'roles';
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function newAction() {
        $form = $this->getServiceLocator()->get($this->form);
        $request = $this->getRequest();
        if($request->isPost()) {
            $form->setData($request->getPost());
            if($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->insert($request->getPost()->toArray());
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }
        return new ViewModel(array('form' => $form));
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function editAction() {
        $request = $this->getRequest();
        $repo = $this->getEm()->getRepository($this->entity);
        $entity = $repo->find($this->params()->fromRoute('id', 0));
        $form = $this->getServiceLocator()->get($this->form);
        if($entity)
            $form->setData($entity->toArray());
        if($request->isPost()) {
            $form->setData($request->getPost());
            if($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }
        return new ViewModel(array('form' => $form));
    }
} 