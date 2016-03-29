<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="profile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 */
class Profile
{
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var int
   *
   * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="profile")
   * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
   */
  private $user;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="dateOfRegistration", type="datetime")
   */
  private $dateOfRegistration;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="dateOfBirth", type="date")
   */
  private $dateOfBirth;

  /**
   * @var string
   *
   * @ORM\Column(name="maritalStatus", type="string", length=10)
   */
  private $maritalStatus;

  /**
   * @var string
   *
   * @ORM\Column(name="gender", type="string", length=10)
   */
  private $gender;

  /**
   * @var string
   *
   * @ORM\Column(name="address", type="string", length=255)
   */
  private $address;

  /**
   * @var string
   *
   * @ORM\Column(name="phone", type="string", length=11)
   */
  private $phone;

  /**
   * @var int
   *
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Department", inversedBy="profiles")
   */
  private $department;

  /**
   * @var int
   *
   * @ORM\Column(name="isQualified", type="boolean", nullable=true)
   */
  private $isQualified;

  /**
   * @var string
   *
   * @ORM\Column(name="state", type="string", length=15)
   */
  private $state;

  /**
   * @var int
   *
   * @ORM\Column(name="annualIncome", type="integer")
   */
  private $annualIncome;

  /**
   * @var int
   *
   * @ORM\Column(name="netWorth", type="integer")
   */
  private $netWorth;

  /**
   * @var int
   *
   * @ORM\Column(name="creditRating", type="integer", nullable=true)
   */
  private $creditRating;

  /**
   * @var ArrayCollection
   *
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Loan", mappedBy="profile")
   */
  private $loans;

  /**
   * @var ArrayCollection
   *
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Payment", mappedBy="profile")
   */
  private $payments;

  /**
   *
   */
  public function __construct()
  {
    $this->loans = new ArrayCollection();
    $this->payments = new ArrayCollection();
  }

  /**
   * Get id
   *
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set userId
   *
   * @param integer $user
   *
   * @return Profile
   */
  public function setUser($user)
  {
    $this->user = $user;

    return $this;
  }

  /**
   * Get userId
   *
   * @return int
   */
  public function getUser()
  {
    return $this->user;
  }

  /**
   * Set dateOfRegistraion
   *
   * @param \DateTime $dateOfRegistration
   *
   * @return Profile
   */
  public function setDateOfRegistration($dateOfRegistration)
  {
    $this->dateOfRegistration = $dateOfRegistration;

    return $this;
  }

  /**
   * Get dateOfRegistraion
   *
   * @return \DateTime
   */
  public function getDateOfRegistration()
  {
    return $this->dateOfRegistration;
  }

  /**
   * Set dateOfBirth
   *
   * @param \DateTime $dateOfBirth
   *
   * @return Profile
   */
  public function setDateOfBirth($dateOfBirth)
  {
    $this->dateOfBirth = $dateOfBirth;

    return $this;
  }

  /**
   * Get dateOfBirth
   *
   * @return \DateTime
   */
  public function getDateOfBirth()
  {
    return $this->dateOfBirth;
  }

  /**
   * Set maritalStatus
   *
   * @param string $maritalStatus
   *
   * @return Profile
   */
  public function setMaritalStatus($maritalStatus)
  {
    $this->maritalStatus = $maritalStatus;

    return $this;
  }

  /**
   * Get maritalStatus
   *
   * @return string
   */
  public function getMaritalStatus()
  {
    return $this->maritalStatus;
  }

  /**
   * Set gender
   *
   * @param string $gender
   *
   * @return Profile
   */
  public function setGender($gender)
  {
    $this->gender = $gender;

    return $this;
  }

  /**
   * Get gender
   *
   * @return string
   */
  public function getGender()
  {
    return $this->gender;
  }

  /**
   * Set address
   *
   * @param string $address
   *
   * @return Profile
   */
  public function setAddress($address)
  {
    $this->address = $address;

    return $this;
  }

  /**
   * Get address
   *
   * @return string
   */
  public function getAddress()
  {
    return $this->address;
  }

  /**
   * Set phone
   *
   * @param string $phone
   *
   * @return Profile
   */
  public function setPhone($phone)
  {
    $this->phone = $phone;

    return $this;
  }

  /**
   * Get phone
   *
   * @return string
   */
  public function getPhone()
  {
    return $this->phone;
  }

  /**
   * Set departmentId
   *
   * @param integer $department
   *
   * @return Profile
   */
  public function setDepartment($department)
  {
    $this->department = $department;

    return $this;
  }

  /**
   * Get departmentId
   *
   * @return int
   */
  public function getDepartment()
  {
    return $this->department;
  }

  /**
   * Set qualificationId
   *
   * @param integer $qualificationId
   *
   * @return Profile
   */
  public function setQualificationId($qualificationId)
  {
    $this->qualificationId = $qualificationId;

    return $this;
  }

  /**
   * Set state
   *
   * @param string $state
   *
   * @return Profile
   */
  public function setState($state)
  {
    $this->state = $state;

    return $this;
  }

  /**
   * Get state
   *
   * @return string
   */
  public function getState()
  {
    return $this->state;
  }

  /**
   * Set annualIncome
   *
   * @param integer $annualIncome
   *
   * @return Profile
   */
  public function setAnnualIncome($annualIncome)
  {
    $this->annualIncome = $annualIncome;

    return $this;
  }

  /**
   * Get annualIncome
   *
   * @return int
   */
  public function getAnnualIncome()
  {
    return $this->annualIncome;
  }

  /**
   * Set netWorth
   *
   * @param integer $netWorth
   *
   * @return Profile
   */
  public function setNetWorth($netWorth)
  {
    $this->netWorth = $netWorth;

    return $this;
  }

  /**
   * Get netWorth
   *
   * @return int
   */
  public function getNetWorth()
  {
    return $this->netWorth;
  }

  /**
   * Set creditRating
   *
   * @param integer $creditRating
   *
   * @return Profile
   */
  public function setCreditRating($creditRating)
  {
    $this->creditRating = $creditRating;

    return $this;
  }

  /**
   * Get creditRating
   *
   * @return int
   */
  public function getCreditRating()
  {
    return $this->creditRating;
  }

  /**
   * Set isQualified
   *
   * @param boolean $isQualified
   *
   * @return Profile
   */
  public function setIsQualified($isQualified)
  {
    $this->isQualified = $isQualified;

    return $this;
  }

  /**
   * Get isQualified
   *
   * @return boolean
   */
  public function getIsQualified()
  {
    return $this->isQualified;
  }

  /**
   * @return ArrayCollection
   */
  public function getLoans()
  {
    return $this->loans;
  }

    /**
     * Add loan
     *
     * @param \AppBundle\Entity\Loan $loan
     *
     * @return Profile
     */
    public function addLoan(\AppBundle\Entity\Loan $loan)
    {
        $this->loans[] = $loan;

        return $this;
    }

    /**
     * Remove loan
     *
     * @param \AppBundle\Entity\Loan $loan
     */
    public function removeLoan(\AppBundle\Entity\Loan $loan)
    {
        $this->loans->removeElement($loan);
    }
}
