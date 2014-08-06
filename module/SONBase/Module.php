<?php

namespace SONBase;

use Zend\Mvc\MvcEvent;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

use Zend\ModuleManager\ModuleManager;

/**
 * Class Module
 * @package SONBase
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

    public function init(ModuleManager $moduleManager) {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach("Zend\Mvc\Controller\AbstractActionController",
            MvcEvent::EVENT_DISPATCH,
            array($this, 'userAuth'), 100);
    }

    public function userAuth($e) {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("SONUser"));
        $controller = $e->getTarget();
        $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
        if(!$auth->hasIdentity() AND (strpos($matchedRoute, "sonbase-admin") !== false OR
             strpos($matchedRoute, "sonuser-admin") !== false OR
             strpos($matchedRoute, "sonacl-admin") !== false)) {
            return $controller->redirect()->toRoute('sonuser-auth');
        }
    }
}
