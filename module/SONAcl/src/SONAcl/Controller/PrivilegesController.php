<?php

namespace SONAcl\Controller;

use Zend\View\Model\ViewModel;
use SONBase\Controller\CrudController;

/**
 * Class PrivilegesController
 * @package SONAcl\Controller
 */
class PrivilegesController extends CrudController {

    public function __construct() {
        $this->service = "SONAcl\Service\Privilege";
        $this->entity = 'SONAcl\Entity\Privilege';
        $this->form = 'SONAcl\Form\Privilege';
        $this->route = 'sonacl-admin/default';
        $this->controller = 'privileges';
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