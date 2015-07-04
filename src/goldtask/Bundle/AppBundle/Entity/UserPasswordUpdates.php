<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPasswordUpdates
 *
 * @ORM\Table(name="user_password_updates")
 * @ORM\Entity
 */
class UserPasswordUpdates
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="random_code", type="string", length=100, nullable=false)
     */
    private $randomCode;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_done", type="boolean", nullable=true)
     */
    private $isDone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_expired", type="boolean", nullable=true)
     */
    private $isExpired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return UserPasswordUpdates
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set randomCode
     *
     * @param string $randomCode
     * @return UserPasswordUpdates
     */
    public function setRandomCode($randomCode)
    {
        $this->randomCode = $randomCode;

        return $this;
    }

    /**
     * Get randomCode
     *
     * @return string 
     */
    public function getRandomCode()
    {
        return $this->randomCode;
    }

    /**
     * Set isDone
     *
     * @param boolean $isDone
     * @return UserPasswordUpdates
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * Get isDone
     *
     * @return boolean 
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * Set isExpired
     *
     * @param boolean $isExpired
     * @return UserPasswordUpdates
     */
    public function setIsExpired($isExpired)
    {
        $this->isExpired = $isExpired;

        return $this;
    }

    /**
     * Get isExpired
     *
     * @return boolean 
     */
    public function getIsExpired()
    {
        return $this->isExpired;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return UserPasswordUpdates
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime 
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }
}
