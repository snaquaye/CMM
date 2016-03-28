<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Payment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * MemberLoan
 *
 * @ORM\Table(name="member_loan")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MemberLoanRepository")
 */
class Loan
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
   * @var string
   *
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Profile", inversedBy="loans")
   */
  private $profile;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="dateIssued", type="date")
   */
  private $dateIssued;

  /**
   * @var int
   *
   * @ORM\Column(name="amount", type="integer")
   */
  private $amount;

  /**
   * @var string
   *
   * @ORM\Column(name="interestRate", type="string", length=255)
   */
  private $interestRate;

  /**
   * @var string
   *
   * @ORM\Column(name="issuedBy", type="string", length=255)
   */
  private $issuedBy;

  /**
   * @var ArrayCollection
   *
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Payment", mappedBy="loan")
   */
  private $payments;

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
   * Set member
   *
   * @param string $profile
   *
   * @return Loan
   */
  public function setProfile($profile)
  {
    $this->profile = $profile;

    return $this;
  }

  /**
   * Get member
   *
   * @return string
   */
  public function getProfile()
  {
    return $this->profile;
  }

  /**
   * Set dateIssued
   *
   * @param \DateTime $dateIssued
   *
   * @return Loan
   */
  public function setDateIssued($dateIssued)
  {
    $this->dateIssued = $dateIssued;

    return $this;
  }

  /**
   * Get dateIssued
   *
   * @return \DateTime
   */
  public function getDateIssued()
  {
    return $this->dateIssued;
  }

  /**
   * Set amount
   *
   * @param integer $amount
   *
   * @return Loan
   */
  public function setAmount($amount)
  {
    $this->amount = $amount;

    return $this;
  }

  /**
   * Get amount
   *
   * @return int
   */
  public function getAmount()
  {
    return $this->amount;
  }

  /**
   * Set interestRate
   *
   * @param string $interestRate
   *
   * @return Loan
   */
  public function setInterestRate($interestRate)
  {
    $this->interestRate = $interestRate;

    return $this;
  }

  /**
   * Get interestRate
   *
   * @return string
   */
  public function getInterestRate()
  {
    return $this->interestRate;
  }

  /**
   * Set issuedBy
   *
   * @param string $issuedBy
   *
   * @return Loan
   */
  public function setIssuedBy($issuedBy)
  {
    $this->issuedBy = $issuedBy;

    return $this;
  }

  /**
   * Get issuedBy
   *
   * @return string
   */
  public function getIssuedBy()
  {
    return $this->issuedBy;
  }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->payments = new ArrayCollection();
    }

    /**
     * Add payment
     *
     * @param Payment $payment
     *
     * @return Loan
     */
    public function addPayment(Payment $payment)
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * Remove payment
     *
     * @param Payment $payment
     */
    public function removePayment(Payment $payment)
    {
        $this->payments->removeElement($payment);
    }

    /**
     * Get payment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }
}
