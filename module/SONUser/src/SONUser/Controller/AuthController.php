<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;
use SONUser\Form\Login as LoginForm;

/**
 * Class AuthController
 * @package SONUser\Controller
 */
class AuthController extends AbstractActionController {

    /**
     * @var bool
     */
    protected $error= false;

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function indexAction() {
        $form = new LoginForm();
        $request = $this->getRequest();
        if($request->isPost()) {
            $form->setData($request->getPost());
            if($form->isValid()) {
                $data = $request->getPost()->toArray();

                $authAdapter = $this->getServiceLocator()->get('SONUser\Auth\Adapter');
                $authAdapter->setUsername($data['email']);
                $authAdapter->setPassword($data['password']);

                $auth = new AuthenticationService();
                $sessionStorage = new SessionStorage('SONUser');
                $auth->setStorage($sessionStorage);

                $result = $auth->authenticate($authAdapter);
                if($result->isValid()) {
                    $sessionStorage->write($auth->getIdentity()['user'], null);
                    return $this->redirect()->toRoute('sonuser-admin/default', array('controller'=>'users'));
                } else {
                    $this->error = true;
                }
            }
        }
        return new ViewModel(array('form' => $form, 'error' => $this->error));
    }

    public function logoutAction() {
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage('SONUser'));
        $auth->clearIdentity();
        return $this->redirect()->toRoute('sonuser-auth');
    }

} 