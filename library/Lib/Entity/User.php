<?php

namespace Lib\Entity;

/**
 * Description of User
 *
 * @author davi
 * @Entity
 * @Table(name="users")
 */
class User extends Base
{

    /**
     * @var integer $id
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     * @Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string $email
     * @Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string $password
     * @Column(name="password", type="string", length=50, nullable=false)
     */
    private $password;

    /**
     * @var string $salt
     * @Column(name="salt", type="string", length=50, nullable=false)
     */
    private $salt;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return \Lib\Entity\User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \Lib\Entity\User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return \Lib\Entity\User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return \Lib\Entity\User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     * @return \Lib\Entity\User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }


}