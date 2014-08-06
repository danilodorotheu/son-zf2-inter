<?php

namespace SONBase\Service;

use Doctrine\ORM\EntityManager;
use Zend\stdLib\Hydrator;

/**
 * Class AbstractService
 * @package SONBase\Service
 */
abstract class AbstractService {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var entity
     */
    protected $entity;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data) {
        $entity = new $this->entity($data);
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    /**
     * @param array $data
     * @return object
     */
    public function update(array $data) {
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    /**
     * @param int $id
     * @return bool|int
     */
    public function delete($id) {
        $entity = $this->em->getReference($this->entity, $id);
        if($entity) {
            $this->em->remove($entity);
            $this->em->flush();
            return $id;
        }
        return false;
    }

} 