<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackingDetails
 *
 * @ORM\Table(name="tracking_details")
 * @ORM\Entity
 */
class TrackingDetails
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
     * @var integer
     *
     * @ORM\Column(name="offices_id", type="integer", nullable=false)
     */
    private $officesId;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="time_diff", type="datetime", nullable=false)
     */
    private $timeDiff;	
	/**
     * @var varchar
     *
     * @ORM\Column(name="session_id", type="varchar", nullable=false)
     */
    private $sessionId;
	private $weight;
	/**
     * @var integer
     *
     * @ORM\Column(name="is_status", type="tinyint", nullable=false)
     */
    private $isStatus;	
   
    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="updated_by", type="integer", nullable=true)
     */
    private $updatedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
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
     * Set userId
     *
     * @param integer $userId
     * @return TrackingDetails
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
     * @return TrackingDetails
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
     * @return TrackingDetails
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
     * @return TrackingDetails
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
     * Set timeDiff
     *
     * @param \DateTime $timeDiff
     * @return TrackingDetails
     */
    public function settimeDiff($timeDiff)
    {
        $this->timeDiff = $timeDiff;

        return $this;
    }

    /**
     * Get timeDiff
     *
     * @return \DateTime 
     */
    public function gettimeDiff()
    {
        return $this->timeDiff;
    }

    /**
     * Set moduleType
     *
     * @param integer $moduleType
     * @return TrackingDetails
     */
    public function setModuleType($moduleType)
    {
        $this->moduleType = $moduleType;

        return $this;
    }

    /**
     * Get moduleType
     *
     * @return integer 
     */
    public function getmoduleType()
    {
        return $this->moduleType;
    }
	 /**
     * Set sessionId
     *
     * @param varchar $sessionId
     * @return TrackingDetails
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return varchar 
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }
	/**
     * Set weight
     *
     * @param \decimal $weight
     * @return TrackingDetails
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }
    /**
     * Get weight
     *
     * @return \decimal 
     */
    public function getWeight()
    {
        return $this->weight;
    }
    /**
     * Set isStatus
     *
     * @param integer $isStatus
     * @return TrackingDetails
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
     * @return TrackingDetails
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
     * @return TrackingDetails
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
     * @return TrackingDetails
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
     * @return TrackingDetails
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
