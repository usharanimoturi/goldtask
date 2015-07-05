<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * customers
 */
class customers
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $customerName;

    /**
     * @var string
     */
    private $weightGrams;

    /**
     * @var integer
     */
    private $userid;

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
     * Set customerName
     *
     * @param string $customerName
     * @return customers
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string 
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set weightGrams
     *
     * @param string $weightGrams
     * @return customers
     */
    public function setWeightGrams($weightGrams)
    {
        $this->weightGrams = $weightGrams;

        return $this;
    }

    /**
     * Get weightGrams
     *
     * @return string 
     */
    public function getWeightGrams()
    {
        return $this->weightGrams;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return customers
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
     * Set createdBy
     *
     * @param integer $createdBy
     * @return customers
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
     * @return customers
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
