<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAccess
 *
 * @ORM\Table(name="user_access")
 * @ORM\Entity
 */
class UserAccess
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
     * @ORM\Column(name="logged_ip", type="string", length=20, nullable=false)
     */
    private $loggedIp;

    /**
     * @var string
     *
     * @ORM\Column(name="logged_browser", type="string", length=50, nullable=false)
     */
    private $loggedBrowser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="logged_at", type="datetime", nullable=true)
     */
    private $loggedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="logout_at", type="datetime", nullable=true)
     */
    private $logoutAt;

    /**
     * @var string
     *
     * @ORM\Column(name="logged_status", type="string", length=10, nullable=true)
     */
    private $loggedStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="logout_status", type="string", length=10, nullable=true)
     */
    private $logoutStatus;
    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=10, nullable=false)
     */
    private $sessionId;


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
     * @return UserAccess
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
     * Set loggedIp
     *
     * @param string $loggedIp
     * @return UserAccess
     */
    public function setLoggedIp($loggedIp)
    {
        $this->loggedIp = $loggedIp;

        return $this;
    }

    /**
     * Get loggedIp
     *
     * @return string 
     */
    public function getLoggedIp()
    {
        return $this->loggedIp;
    }

    /**
     * Set loggedBrowser
     *
     * @param string $loggedBrowser
     * @return UserAccess
     */
    public function setLoggedBrowser($loggedBrowser)
    {
        $this->loggedBrowser = $loggedBrowser;

        return $this;
    }

    /**
     * Get loggedBrowser
     *
     * @return string 
     */
    public function getLoggedBrowser()
    {
        return $this->loggedBrowser;
    }

    /**
     * Set loggedAt
     *
     * @param \DateTime $loggedAt
     * @return UserAccess
     */
    public function setLoggedAt($loggedAt)
    {
        $this->loggedAt = $loggedAt;

        return $this;
    }

    /**
     * Get loggedAt
     *
     * @return \DateTime 
     */
    public function getLoggedAt()
    {
        return $this->loggedAt;
    }

    /**
     * Set logoutAt
     *
     * @param \DateTime $logoutAt
     * @return UserAccess
     */
    public function setLogoutAt($logoutAt)
    {
        $this->logoutAt = $logoutAt;

        return $this;
    }

    /**
     * Get logoutAt
     *
     * @return \DateTime 
     */
    public function getLogoutAt()
    {
        return $this->logoutAt;
    }

    /**
     * Set loggedStatus
     *
     * @param string $loggedStatus
     * @return UserAccess
     */
    public function setLoggedStatus($loggedStatus)
    {
        $this->loggedStatus = $loggedStatus;

        return $this;
    }

    /**
     * Get loggedStatus
     *
     * @return string 
     */
    public function getLoggedStatus()
    {
        return $this->loggedStatus;
    }

    /**
     * Set logoutStatus
     *
     * @param string $logoutStatus
     * @return UserAccess
     */
    public function setLogoutStatus($logoutStatus)
    {
        $this->logoutStatus = $logoutStatus;

        return $this;
    }

    /**
     * Get logoutStatus
     *
     * @return string 
     */
    public function getLogoutStatus()
    {
        return $this->logoutStatus;
    }
	/**
     * Set sessionId
     *
     * @param string $sessionId
     * @return UserAccess
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string 
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }
}
