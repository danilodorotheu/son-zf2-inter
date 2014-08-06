<?php

namespace SONAcl;

/**
 * Class Module
 * @package SONAcl
 */
class Module {

    /**
     * @return mixed
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'SONAcl\Permissions\Acl' => function ($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $roleRepository = $em->getRepository('SONAcl\Entity\Role');
                    $roles = $roleRepository->findAll();
                    $resourceRepository = $em->getRepository('SONAcl\Entity\Resource');
                    $resources = $resourceRepository->findAll();
                    $privilegeRepository = $em->getRepository('SONAcl\Entity\Privilege');
                    $privileges = $privilegeRepository->findAll();
                    return new Permissions\Acl($roles, $resources, $privileges);
                },
                'SONAcl\Service\Role' => function ($sm) {
                    return new Service\Role($sm->get('Doctrine\ORM\EntityManager'));
                },
                'SONAcl\Service\Resource' => function ($sm) {
                    return new Service\Resource($sm->get('Doctrine\ORM\EntityManager'));
                },
                'SONAcl\Form\Role' => function ($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $repository = $em->getRepository('SONAcl\Entity\Role');
                    $parent = $repository->fetchPairs();
                    return new Form\Role('Role', $parent);
                },
                'SONAcl\Service\Privilege' => function ($sm) {
                    return new Service\Privilege($sm->get('Doctrine\ORM\EntityManager'));
                },
                'SONAcl\Form\Privilege' => function ($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $roleRepository = $em->getRepository('SONAcl\Entity\Role');
                    $roles = $roleRepository->fetchPairs();
                    $resourceRepository = $em->getRepository('SONAcl\Entity\Resource');
                    $resources = $resourceRepository->fetchPairs();
                    return new Form\Privilege('Privilege', $roles, $resources);
                },
            ),
        );
    }

}
