<?php
namespace Index\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User {

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usu_email", type="string", length=255, nullable=false)
     */
    private $usu_email;

    /**
     * @var string
     *
     * @ORM\Column(name="usu_password", type="string", length=255, nullable=false)
     */
    private $usu_password;

    /**
     * @var integer
     *
     * @ORM\Column(name="usu_is_active", type="smallint", nullable=false)
     */
    private $isActive = '1';

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set usu_email
     *
     * @param string $usu_email
     * @return User
     */
    public function setEmail($usu_email) {
        $this->usu_email = $usu_email;
        return $this;
    }

    /**
     * Get usu_email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->usu_email;
    }

    /**
     * Set usu_password
     *
     * @param string $usu_password
     * @return User
     */
    public function setPassword($usu_password) {
        $this->usu_password = $usu_password;
        return $this;
    }

    /**
     * Get usu_password
     *
     * @return string 
     */
    public function getUsu_password() {
        return $this->usu_password;
    }

    /**
     * Set isActive
     *
     * @param integer $isActive
     * @return User
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * Get isActive
     *
     * @return integer 
     */
    public function getIsActive() {
        return $this->isActive;
    }
}