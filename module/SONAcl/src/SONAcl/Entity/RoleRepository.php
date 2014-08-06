<?php

namespace SONAcl\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class RoleRepository
 * @package SONAcl\Entity
 */
class RoleRepository extends EntityRepository {

    public function fetchPairs() {
        $entities = $this->findAll();
        $array = array();
        foreach($entities as $entity) {
            $array[$entity->getId()] = $entity->getNome();
        }
        return $array;
    }

} 