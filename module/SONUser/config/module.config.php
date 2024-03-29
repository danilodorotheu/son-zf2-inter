<?php

namespace SONUser;

return array(
    'router' => array(
        'routes' => array(
            'sonuser-register' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/user/register',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SONUser\Controller',
                        'controller' => 'Index',
                        'action'     => 'register',
                    ),
                ),
            ),
            'sonuser-activate' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/user/register/activate[/:key]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SONUser\Controller',
                        'controller' => 'Index',
                        'action'     => 'activate',
                    ),
                ),
            ),
            'sonuser-auth' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SONUser\Controller',
                        'controller' => 'Auth',
                        'action'     => 'index',
                    ),
                ),
            ),
            'sonuser-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SONUser\Controller',
                        'controller' => 'Auth',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'sonuser-admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SONUser/Controller',
                        'controller' => 'Users',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'SONUser\Controller',
                                'controller' => 'users'
                            ),
                        ),
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'SONUser\Controller',
                                'controller' => 'users'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'SONUser\Controller\Index' => 'SONUser\Controller\IndexController',
            'SONUser\Controller\Users' => 'SONUser\Controller\UsersController',
            'SONUser\Controller\Auth' => 'SONUser\Controller\AuthController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../../SONBase/view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../../SONBase/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../SONBase/view/error/index.phtml',
            'partials/paginator'      => __DIR__ . '/../../SONBase/view/partials/paginator.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    'data-fixture' => array(
        'SONUser_fixture' => __DIR__ . '/../src/SONUser/Fixture',
    ),
);