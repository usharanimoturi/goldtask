<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRoles
 *
 * @ORM\Table(name="user_roles")
 * @ORM\Entity
 */
class UserRoles
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
     * @ORM\Column(name="parent_role_id", type="integer", nullable=false)
     */
    private $parentRoleId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_parent", type="boolean", nullable=false)
     */
    private $isParent;

    /**
     * @var string
     *
     * @ORM\Column(name="role_name", type="string", length=50, nullable=false)
     */
    private $roleName;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50, nullable=false)
     */
    private $slug;



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
     * Set parentRoleId
     *
     * @param integer $parentRoleId
     * @return UserRoles
     */
    public function setParentRoleId($parentRoleId)
    {
        $this->parentRoleId = $parentRoleId;

        return $this;
    }

    /**
     * Get parentRoleId
     *
     * @return integer 
     */
    public function getParentRoleId()
    {
        return $this->parentRoleId;
    }

    /**
     * Set isParent
     *
     * @param boolean $isParent
     * @return UserRoles
     */
    public function setIsParent($isParent)
    {
        $this->isParent = $isParent;

        return $this;
    }

    /**
     * Get isParent
     *
     * @return boolean 
     */
    public function getIsParent()
    {
        return $this->isParent;
    }

    /**
     * Set roleName
     *
     * @param string $roleName
     * @return UserRoles
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * Get roleName
     *
     * @return string 
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return UserRoles
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
