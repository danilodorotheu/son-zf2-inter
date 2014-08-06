<?php

namespace SONBase\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;

/**
 * Class CrudController
 * @package SONBase\Controller
 */
abstract class CrudController extends AbstractActionController {

    protected $em;
    protected $service;
    protected $entity;
    protected $form;
    protected $route;
    protected $controller;

    /**
     * @return array|ViewModel
     */
    public function indexAction() {
        $list = $this->getEm()->getRepository($this->entity)->findAll();
        $page = $this->params()->fromRoute('page');
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)->setDefaultItemCountPerPage(10);
        return new ViewModel(array('data' => $paginator, 'page'=>$page));
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function newAction() {
        $form = new $this->form;
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
        $form = new $this->form;
        if($entity)
            $form->setData($entity->toArray());
        if($request->isPost()) {
            $data = $request->getPost();
            if(empty($data['password']))
                unset($data['password']);
            $form->setData($data);
            if($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function deleteAction() {
        $service = $this->getServiceLocator()->get($this->service);
        if($service->delete($this->params()->fromRoute('id', 0)))
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
    }

    /**
     * @return array|object
     */
    protected function getEm() {
        if($this->em === null)
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        return $this->em;
    }

} 