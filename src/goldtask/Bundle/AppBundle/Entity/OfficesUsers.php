<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfficesUsers
 *
 * @ORM\Table(name="offices_users", indexes={@ORM\Index(name="office_usersFK_idx", columns={"user_id"}), @ORM\Index(name="officeFK_idx", columns={"offices_id"})})
 * @ORM\Entity
 */
class OfficesUsers
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
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="offices_id", type="integer", nullable=true)
     */
    private $officesId;



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
     * @return OfficesUsers
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
     * Set officesId
     *
     * @param integer $officesId
     * @return OfficesUsers
     */
    public function setOfficesId($officesId)
    {
        $this->officesId = $officesId;

        return $this;
    }

    /**
     * Get officesId
     *
     * @return integer 
     */
    public function getOfficesId()
    {
        return $this->officesId;
    }
}
