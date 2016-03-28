<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentRepository")
 */
class Payment
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
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Profile", inversedBy="payments")
   */
  private $profile;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="dateOfPayment", type="date")
   */
  private $dateOfPayment;

  /**
   * @var Loan
   *
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Loan", inversedBy="payments")
   */
  private $loan;

  /**
   * @var string
   *
   * @ORM\Column(name="paymentMonth", type="string", length=255)
   */
  private $paymentMonth;

  /**
   * @var int
   *
   * @ORM\Column(name="amountPaid", type="integer")
   */
  private $amountPaid;


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
   * @return Payment
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
   * Set dateOfPayment
   *
   * @param \DateTime $dateOfPayment
   *
   * @return Payment
   */
  public function setDateOfPayment($dateOfPayment)
  {
    $this->dateOfPayment = $dateOfPayment;

    return $this;
  }

  /**
   * Get dateOfPayment
   *
   * @return \DateTime
   */
  public function getDateOfPayment()
  {
    return $this->dateOfPayment;
  }

  /**
   * Set paymentMonth
   *
   * @param string $paymentMonth
   *
   * @return Payment
   */
  public function setPaymentMonth($paymentMonth)
  {
    $this->paymentMonth = $paymentMonth;

    return $this;
  }

  /**
   * Get paymentMonth
   *
   * @return string
   */
  public function getPaymentMonth()
  {
    return $this->paymentMonth;
  }

  /**
   * Set amountPaid
   *
   * @param integer $amountPaid
   *
   * @return Payment
   */
  public function setAmountPaid($amountPaid)
  {
    $this->amountPaid = $amountPaid;

    return $this;
  }

  /**
   * Get amountPaid
   *
   * @return int
   */
  public function getAmountPaid()
  {
    return $this->amountPaid;
  }

    /**
     * Set loan
     *
     * @param \AppBundle\Entity\Loan $loan
     *
     * @return Payment
     */
    public function setLoan(\AppBundle\Entity\Loan $loan = null)
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get loan
     *
     * @return \AppBundle\Entity\Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }
}
