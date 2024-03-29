<?php

namespace SONAcl\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class ResourceRepository
 * @package SONAcl\Entity
 */
class ResourceRepository extends EntityRepository {

    public function fetchPairs() {
        $entities = $this->findAll();
        $array = array();
        foreach($entities as $entity) {
            $array[$entity->getId()] = $entity->getNome();
        }
        return $array;
    }

} 