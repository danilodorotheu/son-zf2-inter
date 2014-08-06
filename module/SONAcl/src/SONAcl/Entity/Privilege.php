<?php

namespace SONAcl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Privilege
 *
 * @ORM\Table(name="sonacl_privileges")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="SONAcl\Entity\PrivilegeRepository")
 */
class Privilege {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Entity
     *
     * @ORM\OneToOne(targetEntity="SONAcl\Entity\Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

    /**
     * @var Entity
     *
     * @ORM\OneToOne(targetEntity="SONAcl\Entity\Resource")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     */
    private $resource;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=true)
     */
    private $nome;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @param array $options
     */
    public function __construct($options = array()) {
        (new Hydrator\ClassMethods)->hydrate($options, $this);
        $this->createdAt = new \Datetime("now");
        $this->updatedAt = new \Datetime("now");
    }

    /**
     * @param int $id
     * @return object $this
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param \SONAcl\Entity\Entity $role
     * @return object $this
     */
    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    /**
     * @return \SONAcl\Entity\Entity
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @param \SONAcl\Entity\Entity $resource
     * @return object $this
     */
    public function setResource($resource) {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return \SONAcl\Entity\Entity
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * @param string $nome
     * @return object $this
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * @return object $this
     */
    public function setCreatedAt() {
        $this->createdAt = new \Datetime("now");
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     * @return object $this
     */
    public function setUpdateAt() {
        $this->updateAt = new \Datetime("now");
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt() {
        return $this->updateAt;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->nome;
    }

    /**
     * @return array
     */
    public function toArray() {
        return array(
            'id' => $this->id,
            'role' => $this->role->getId(),
            'resource' => $this->resource->getId(),
            'nome' => $this->nome
        );
    }

}
