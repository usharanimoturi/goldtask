<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * clockindetails
 */
class clockindetails
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var integer
     */
    private $officesId;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var integer
     */
    private $sessionIds;

    /**
     * @var integer
     */
    private $isStatus;

    /**
     * @var integer
     */
    private $createdBy;

    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @var integer
     */
    private $updatedBy;

    /**
     * @var \DateTime
     */
    private $updatedOn;


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
     * Set userid
     *
     * @param integer $userid
     * @return clockindetails
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set officesId
     *
     * @param integer $officesId
     * @return clockindetails
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

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return clockindetails
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return clockindetails
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set sessionIds
     *
     * @param string $sessionIds
     * @return clockindetails
     */
    public function setSessionIds($sessionIds)
    {
        $this->sessionIds = $sessionIds;

        return $this;
    }

    /**
     * Get sessionIds
     *
     * @return string 
     */
    public function getSessionIds()
    {
        return $this->sessionIds;
    }

    /**
     * Set isStatus
     *
     * @param integer $isStatus
     * @return clockindetails
     */
    public function setIsStatus($isStatus)
    {
        $this->isStatus = $isStatus;

        return $this;
    }

    /**
     * Get isStatus
     *
     * @return integer 
     */
    public function getIsStatus()
    {
        return $this->isStatus;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     * @return clockindetails
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return clockindetails
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

    /**
     * Set updatedBy
     *
     * @param integer $updatedBy
     * @return clockindetails
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return integer 
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set updatedOn
     *
     * @param \DateTime $updatedOn
     * @return clockindetails
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get updatedOn
     *
     * @return \DateTime 
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }
}
