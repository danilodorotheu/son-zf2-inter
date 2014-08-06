<?php

namespace SONAcl\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use SONBase\Service\AbstractService;

class Privilege extends AbstractService {

    public function __construct(EntityManager $entityManager) {
        parent::__construct($entityManager);
        $this->entity = "SONAcl\Entity\Privilege";
    }

    public function insert(array $data) {
        $entity = new $this->entity($data);

        $role = $this->em->getReference('SONAcl\Entity\Role', $data['role']);
        $entity->setRole($role);

        $resource = $this->em->getReference('SONAcl\Entity\Resource', $data['resource']);
        $entity->setResource($resource);

        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    public function update(array $data) {
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator\ClassMethods())->hydrate($data, $entity);

        $role = $this->em->getReference('SONAcl\Entity\Role', $data['role']);
        $entity->setRole($role);

        $resource = $this->em->getReference('SONAcl\Entity\Resource', $data['resource']);
        $entity->setResource($resource);
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

} 