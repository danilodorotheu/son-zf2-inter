<?php

namespace SONUser\Service;

use Zend\stdLib\Hydrator,
    zend\Mail\Transport\Smtp as SmtpTransport;
use Doctrine\ORM\EntityManager;
use SONBase\Mail\Mail;

/**
 * Class User
 * @package SONUser\Service
 */
class User extends AbstractService {

    protected $transport;
    protected $view;

    /**
     * @param EntityManager $em
     * @param SmtpTransport $transport
     * @param $view
     */
    public function __construct(EntityManager $em, SmtpTransport $transport, $view) {
        parent::__construct($em);
        $this->entity = "SONUser\Entity\User";
        $this->transport = $transport;
        $this->view = $view;
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function insert(array $data) {
        $entity = parent::insert($data);
        $dataEmail = array('nome' => $data['nome'], 'activationKey' => $entity->getActivationKey());
        if($entity) {
            $mail = new Mail($this->transport, $this->view, 'add-user');
            $mail->setSubject('Confimação de cadastro')
                ->setTo($data['email'])
                ->setData($dataEmail)
                ->prepare()
                ->send();
            return $entity;
        }
        return false;
    }

    /**
     * @param array $data
     * @return object
     */
    public function update(array $data) {
        if(empty($data['password'])) {
            unset($data['password']);
        }
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    /**
     * @param $key
     * @return bool
     */
    public function activate($key) {
        $repo = $this->em->getRepository("SONUser\Entity\User");
        $user = $repo->findOneByActivationKey($key);
        if($user && !$user->getActive()) {
            $user->setActive(true);
            $this->em->persist($user);
            $this->em->flush();
            return $user;
        }
        return false;
    }

} 