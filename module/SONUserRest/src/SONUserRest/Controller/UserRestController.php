<?php

namespace SONUserRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController,
    Zend\View\Model\JsonModel;

/**
 * Class UserRest
 *
 * @package SONUserRest\Controller
 */
class UserRestController extends AbstractRestfulController {

    /**
     * Método GET
     *
     * @return mixed|JsonModel
     */
    public function getList() {
        $EntityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $UserRepository = $EntityManager->getRepository('SONUser\Entity\User');
        $users = $UserRepository->findAllArray();

        return new JsonModel(array('users' => $users));
    }

    /**
     * Método GET
     *
     * @param mixed $id
     * @return mixed|JsonModel
     */
    public function get($id) {
        $EntityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $UserRepository = $EntityManager->getRepository('SONUser\Entity\User');
        $user = $UserRepository->find($id)->toArray();

        return new JsonModel(array('user' => $user));
    }

    /**
     * Método POST
     *
     * @param array $data
     * @return mixed|void
     */
    public function create(array $data) {
        $userService = $this->getServiceLocator()->get('SONUser\Service\User');
        if($data) {
            $user = $userService->insert($data);
            if($user)
                return new JsonModel(array('user' => $user->toArray(), 'success' => true));
            else
                return new JsonModel(array('success' => false));
        } else {
            return new JsonModel(array('success' => false));
        }
    }

    /**
     * Método PUT
     *
     * @param mixed $id
     * @param array $data
     * @return mixed|void
     */
    public function update($id, array $data) {
        $userService = $this->getServiceLocator()->get('SONUser\Service\User');
        if($data) {
            $data['id'] = $id;
            $user = $userService->update($data);
            if($user)
                return new JsonModel(array('user' => $user->toArray(), 'success' => true));
            else
                return new JsonModel(array('success' => false));
        } else {
            return new JsonModel(array('success' => false));
        }
    }

    /**
     * Método DELETE
     *
     * @param mixed $id
     * @return mixed|void
     */
    public function delete($id) {
        $userService = $this->getServiceLocator()->get('SONUser\Service\User');
        if($id) {
            $user = $userService->delete($id);
            if($user)
                return new JsonModel(array('success' => true));
            else
                return new JsonModel(array('success' => false));
        } else {
            return new JsonModel(array('success' => false));
        }
    }

} 