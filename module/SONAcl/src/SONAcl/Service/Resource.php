<?php

namespace SONAcl\Service;

use Doctrine\ORM\EntityManager;
use SONBase\Service\AbstractService;

class Resource extends AbstractService {

    public function __construct(EntityManager $entityManager) {
        parent::__construct($entityManager);
        $this->entity = "SONAcl\Entity\Resource";
    }

} 