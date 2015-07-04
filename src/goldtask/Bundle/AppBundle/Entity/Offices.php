<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offices
 *
 * @ORM\Table(name="offices")
 * @ORM\Entity
 */
class Offices
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="legal_name", type="string", length=200, nullable=true)
     */
    private $legalName;

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
     * @ORM\Column(name="modified_by", type="integer", nullable=false)
     */
    private $modifiedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_on", type="datetime", nullable=true)
     */
    private $modifiedOn;
	
	/**
     * @var string
	 *
	 * @ORM\Column(name="office_ip_number", type="string", length=20, nullable=true)
     */
    private $officeIpNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;


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
     * Set name
     *
     * @param string $name
     * @return Offices
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set legalName
     *
     * @param string $legalName
     * @return Offices
     */
    public function setLegalName($legalName)
    {
        $this->legalName = $legalName;

        return $this;
    }

    /**
     * Get legalName
     *
     * @return string 
     */
    public function getLegalName()
    {
        return $this->legalName;
    }
	
	/**
     * Set createdBy
     *
     * @param integer $createdBy
     * @return Offices
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
     * @return Offices
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
     * Set modifiedBy
     *
     * @param integer $modifiedBy
     * @return Offices
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return integer 
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Set modifiedOn
     *
     * @param \DateTime $modifiedOn
     * @return Offices
     */
    public function setModifiedOn($modifiedOn)
    {
        $this->modifiedOn = $modifiedOn;

        return $this;
    }

    /**
     * Get modifiedOn
     *
     * @return \DateTime 
     */
    public function getModifiedOn()
    {
        return $this->modifiedOn;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Offices
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
	
	/**
     * Set officeIpNumber
     *
     * @param string $officeIpNumber
     * @return Offices
     */
    public function setOfficeIpNumber($officeIpNumber)
    {
        $this->officeIpNumber = $officeIpNumber;

        return $this;
    }

    /**
     * Get officeIpNumber
     *
     * @return string 
     */
    public function getOfficeIpNumber()
    {
        return $this->officeIpNumber;
    }
}
