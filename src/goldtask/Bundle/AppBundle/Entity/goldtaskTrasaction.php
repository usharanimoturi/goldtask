<?php

namespace goldtask\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * goldtaskTrasaction
 *
 * @ORM\Table(name="goldtask_trasaction", uniqueConstraints={@ORM\UniqueConstraint(name="unoffi", columns={"offices_id", "pat_id", "schedule_date"})}, indexes={@ORM\Index(name="assigned_to", columns={"assigned_to"}), @ORM\Index(name="appointment", columns={"missed_appointment", "outstanding_treatment", "outstanding_balance"}), @ORM\Index(name="inoffi", columns={"offices_id", "pat_id"}), @ORM\Index(name="offices", columns={"offices_id"})})
 * @ORM\Entity
 */
class goldtaskTrasaction
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
     * @ORM\Column(name="offices_id", type="integer", nullable=false)
     */
    private $officesId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pat_id", type="integer", nullable=false)
     */
    private $patId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="schedule_date", type="date", nullable=true)
     */
    private $scheduleDate;

    /**
     * @var string
     *
     * @ORM\Column(name="privacynote", type="text", nullable=true)
     */
    private $privacynote;

    /**
     * @var integer
     *
     * @ORM\Column(name="assigned_to", type="integer", nullable=true)
     */
    private $assignedTo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="missed_appointment", type="boolean", nullable=true)
     */
    private $missedAppointment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="outstanding_treatment", type="boolean", nullable=true)
     */
    private $outstandingTreatment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="outstanding_balance", type="boolean", nullable=true)
     */
    private $outstandingBalance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reschedule_date", type="date", nullable=true)
     */
    private $rescheduleDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reschedule_time", type="time", nullable=true)
     */
    private $rescheduleTime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="call_status", type="boolean", nullable=true)
     */
    private $callStatus;

    /**
     * @var boolean
     *
     * @ORM\Column(name="freeze", type="boolean", nullable=true)
     */
    private $freeze;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cdate", type="datetime", nullable=true)
     */
    private $cdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="uid", type="integer", nullable=true)
     */
    private $uid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="udate", type="datetime", nullable=true)
     */
    private $udate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="assigned_date", type="datetime", nullable=true)
     */
    private $assignedDate;



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
     * Set officesId
     *
     * @param integer $officesId
     * @return goldtaskTrasaction
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
     * Set patId
     *
     * @param integer $patId
     * @return goldtaskTrasaction
     */
    public function setPatId($patId)
    {
        $this->patId = $patId;

        return $this;
    }

    /**
     * Get patId
     *
     * @return integer 
     */
    public function getPatId()
    {
        return $this->patId;
    }

    /**
     * Set scheduleDate
     *
     * @param \DateTime $scheduleDate
     * @return goldtaskTrasaction
     */
    public function setScheduleDate($scheduleDate)
    {
        $this->scheduleDate = $scheduleDate;

        return $this;
    }

    /**
     * Get scheduleDate
     *
     * @return \DateTime 
     */
    public function getScheduleDate()
    {
        return $this->scheduleDate;
    }

    /**
     * Set privacynote
     *
     * @param string $privacynote
     * @return goldtaskTrasaction
     */
    public function setPrivacynote($privacynote)
    {
        $this->privacynote = $privacynote;

        return $this;
    }

    /**
     * Get privacynote
     *
     * @return string 
     */
    public function getPrivacynote()
    {
        return $this->privacynote;
    }

    /**
     * Set assignedTo
     *
     * @param integer $assignedTo
     * @return goldtaskTrasaction
     */
    public function setAssignedTo($assignedTo)
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }

    /**
     * Get assignedTo
     *
     * @return integer 
     */
    public function getAssignedTo()
    {
        return $this->assignedTo;
    }

    /**
     * Set missedAppointment
     *
     * @param boolean $missedAppointment
     * @return goldtaskTrasaction
     */
    public function setMissedAppointment($missedAppointment)
    {
        $this->missedAppointment = $missedAppointment;

        return $this;
    }

    /**
     * Get missedAppointment
     *
     * @return boolean 
     */
    public function getMissedAppointment()
    {
        return $this->missedAppointment;
    }

    /**
     * Set outstandingTreatment
     *
     * @param boolean $outstandingTreatment
     * @return goldtaskTrasaction
     */
    public function setOutstandingTreatment($outstandingTreatment)
    {
        $this->outstandingTreatment = $outstandingTreatment;

        return $this;
    }

    /**
     * Get outstandingTreatment
     *
     * @return boolean 
     */
    public function getOutstandingTreatment()
    {
        return $this->outstandingTreatment;
    }

    /**
     * Set outstandingBalance
     *
     * @param boolean $outstandingBalance
     * @return goldtaskTrasaction
     */
    public function setOutstandingBalance($outstandingBalance)
    {
        $this->outstandingBalance = $outstandingBalance;

        return $this;
    }

    /**
     * Get outstandingBalance
     *
     * @return boolean 
     */
    public function getOutstandingBalance()
    {
        return $this->outstandingBalance;
    }

    /**
     * Set rescheduleDate
     *
     * @param \DateTime $rescheduleDate
     * @return goldtaskTrasaction
     */
    public function setRescheduleDate($rescheduleDate)
    {
        $this->rescheduleDate = $rescheduleDate;

        return $this;
    }

    /**
     * Get rescheduleDate
     *
     * @return \DateTime 
     */
    public function getRescheduleDate()
    {
        return $this->rescheduleDate;
    }

    /**
     * Set rescheduleTime
     *
     * @param \DateTime $rescheduleTime
     * @return goldtaskTrasaction
     */
    public function setRescheduleTime($rescheduleTime)
    {
        $this->rescheduleTime = $rescheduleTime;

        return $this;
    }

    /**
     * Get rescheduleTime
     *
     * @return \DateTime 
     */
    public function getRescheduleTime()
    {
        return $this->rescheduleTime;
    }

    /**
     * Set callStatus
     *
     * @param boolean $callStatus
     * @return goldtaskTrasaction
     */
    public function setCallStatus($callStatus)
    {
        $this->callStatus = $callStatus;

        return $this;
    }

    /**
     * Get callStatus
     *
     * @return boolean 
     */
    public function getCallStatus()
    {
        return $this->callStatus;
    }

    /**
     * Set freeze
     *
     * @param boolean $freeze
     * @return goldtaskTrasaction
     */
    public function setFreeze($freeze)
    {
        $this->freeze = $freeze;

        return $this;
    }

    /**
     * Get freeze
     *
     * @return boolean 
     */
    public function getFreeze()
    {
        return $this->freeze;
    }

    /**
     * Set cdate
     *
     * @param \DateTime $cdate
     * @return goldtaskTrasaction
     */
    public function setCdate($cdate)
    {
        $this->cdate = $cdate;

        return $this;
    }

    /**
     * Get cdate
     *
     * @return \DateTime 
     */
    public function getCdate()
    {
        return $this->cdate;
    }

    /**
     * Set uid
     *
     * @param integer $uid
     * @return goldtaskTrasaction
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return integer 
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set udate
     *
     * @param \DateTime $udate
     * @return goldtaskTrasaction
     */
    public function setUdate($udate)
    {
        $this->udate = $udate;

        return $this;
    }

    /**
     * Get udate
     *
     * @return \DateTime 
     */
    public function getUdate()
    {
        return $this->udate;
    }

    /**
     * Set assignedDate
     *
     * @param \DateTime $assignedDate
     * @return goldtaskTrasaction
     */
    public function setAssignedDate($assignedDate)
    {
        $this->assignedDate = $assignedDate;

        return $this;
    }

    /**
     * Get assignedDate
     *
     * @return \DateTime 
     */
    public function getAssignedDate()
    {
        return $this->assignedDate;
    }
}
