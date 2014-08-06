<?php

namespace SONUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Math\Rand,
    Zend\Crypt\Key\Derivation\Pbkdf2,
    Zend\Stdlib\Hydrator;

/**
 * Users
 *
 * @ORM\Table(name="sonuser_users")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SONUser\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User {
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
     * @ORM\Column(name="nome", type="string", length=255, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_key", type="string", length=255, nullable=true)
     */
    private $activationKey;

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
    public function __construct(array $options = array()) {
        (new Hydrator\ClassMethods)->hydrate($options, $this);
        $this->createdAt = new \DateTime("now");
        $this->updateAt = new \DateTime("now");
        $this->salt = base64_encode(Rand::getBytes(8, true));
        $this->activationKey = md5($this->email.$this->salt);
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
     * @return int $this->id
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
     * @return string $this->nome
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * @param string $email
     * @return object $this
     *
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string $this->email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $password
     * @return object $this
     */
    public function setPassword($password) {
        $this->password = $this->encryptPassword($password);
        return $this;
    }

    /**
     * @return string $this->password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $salt
     * @return object $this
     */
    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    /**
     * @return string $this->salt
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * @param boolean $active
     * @return object $this
     */
    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    /**
     * @return boolean $this->active
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * @param string $activationKey
     * @return object $this
     */
    public function setActivationKey($activationKey) {
        $this->activationKey = $activationKey;
        return $this;
    }

    /**
     * @return string $this->activationKey
     */
    public function getActivationKey() {
        return $this->activationKey;
    }

    /**
     * @param \DateTime $createdAt
     * @return object $this
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = new \DateTime("now");
        return $this;
    }

    /**
     * @return \DateTime $this->createdAt
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @return object $this
     *
     * @ORM\prePersist
     */
    public function setUpdateAt() {
        $this->updateAt = new \DateTime("now");
        return $this;
    }

    /**
     * @return \DateTime $this->updateAt
     */
    public function getUpdateAt() {
        return $this->updateAt;
    }

    /**
     * @param $password
     * @return string
     */
    public function encryptPassword($password) {
        return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 10000, strlen($password*2)));
    }

    /**
     * @return array
     */
    public function toArray() {
        return (new Hydrator\ClassMethods())->extract($this);
    }


}
