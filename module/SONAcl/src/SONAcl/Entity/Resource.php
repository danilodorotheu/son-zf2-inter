<?php

namespace SONAcl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Resource
 *
 * @ORM\Table(name="sonacl_resources")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="SONAcl\Entity\ResourceRepository")
 */
class Resource {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
        return (new Hydrator\ClassMethods())->extract($this);
    }

}
