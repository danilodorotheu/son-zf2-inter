<?php

namespace SONUser\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package SONUser\Entity
 */
class UserRepository extends EntityRepository {

    /**
     * @param $email
     * @param $password
     * @return Entity|bool
     */
    public function findByEmailAndPassword($email, $password) {
        $user = $this->findOneByEmail($email);
        if($user) {
            $hashPassword = $user->encryptPassword($password);
            if($hashPassword == $user->getPassword())
                return $user;
            else
                return false;
        } else {
            return false;
        }
    }

    public function findAllArray() {
        $users = $this->findAll();
        $array = array();
        foreach($users as $user) {
            $array[$user->getId()]['id'] = $user->getId();
            $array[$user->getId()]['nome'] = $user->getNome();
            $array[$user->getId()]['email'] = $user->getEmail();
        }
        return $array;
    }

} 