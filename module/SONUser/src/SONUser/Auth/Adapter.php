<?php

namespace SONUser\Auth;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result;
use Doctrine\ORM\EntityManager;

/**
 * Class Adapter
 * @package SONUser\Auth
 */
class Adapter implements AdapterInterface {

    /**
     * @var
     */
    protected $em;
    /**
     * @var
     */
    protected $username;
    /**
     * @var
     */
    protected $password;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return Result
     */
    public function authenticate() {
        $repository = $this->em->getRepository('SONUser\Entity\User');
        $user = $repository->findByEmailAndPassword($this->getUsername(), $this->getPassword());
        if($user)
            return new Result(Result::SUCCESS, array('user' => $user), array('OK'));
        else
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array());
    }
    
} 