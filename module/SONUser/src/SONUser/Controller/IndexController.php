<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use SONUser\Form\User as FormUser;

/**
 * Class IndexController
 * @package SONUser\src\SONUser\Controller
 */
class IndexController extends AbstractActionController {

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function registerAction() {
        $form = new FormUser();
        $request = $this->getRequest();
        if($request->isPost()) {
            $form->setData($request->getPost());
            if($form->isValid()) {
                $service = $this->getServiceLocator()->get('SONUser\Service\User');
                if($service->insert($request->getPost()->toArray())) {
                    $this->flashMessenger()
                        ->setNamespace('SONUser')
                        ->addMessage('Usuário cadastrado com sucesso');
                }
                $messages = $this->flashMessenger()
                    ->setNamespace('SONUser')
                    ->getMessages();
                return new ViewModel(array('form' => $form, 'messages' => $messages));
            }
        }
        $messages = $this->flashMessenger()
            ->setNamespace('SONUser')
            ->getMessages();
        return new ViewModel(array('form' => $form, 'messages' => $messages));
    }

    /**
     * @return ViewModel
     */
    public function activateAction() {
        $activationKey = $this->params()->fromRoute('key');
        $userService = $this->getServiceLocator()->get('SONUser\Service\User');
        $result = $userService->activate($activationKey);
        if($result) {
            return new ViewModel(array('user'=>$result));
        } else {
            return new ViewModel();
        }
    }

}