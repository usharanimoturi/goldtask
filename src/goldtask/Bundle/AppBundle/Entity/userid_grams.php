<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * userid_grams
 */
class userid_grams
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var integer
     */
    private $officesId;

    /**
     * @var \DateTime
     */
    private $sellDate;

    /**
     * @var float
     */
    private $weightGrams;

    /**
     * @var integer
     */
    private $createdBy;

    /**
     * @var \DateTime
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
     * @return userid_grams
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
     * @return userid_grams
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
     * Set sellDate
     *
     * @param \DateTime $sellDate
     * @return userid_grams
     */
    public function setSellDate($sellDate)
    {
        $this->sellDate = $sellDate;

        return $this;
    }

    /**
     * Get sellDate
     *
     * @return \DateTime 
     */
    public function getSellDate()
    {
        return $this->sellDate;
    }

    /**
     * Set weightGrams
     *
     * @param float $weightGrams
     * @return userid_grams
     */
    public function setWeightGrams($weightGrams)
    {
        $this->weightGrams = $weightGrams;

        return $this;
    }

    /**
     * Get weightGrams
     *
     * @return float 
     */
    public function getWeightGrams()
    {
        return $this->weightGrams;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     * @return userid_grams
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
     * @return userid_grams
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
