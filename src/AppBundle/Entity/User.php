<?php
/**
 * Created by PhpStorm.
 * User: SNAQuaye
 * Date: 3/24/2016
 * Time: 1:57 AM
 */

namespace AppBundle\Entity;


use AppBundle\Entity\Profile;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  protected $id;

  /**
   * @ORM\Column(type="string")
   */
  private $firstName;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $otherNames;

  /**
   * @ORM\Column(type="string")
   */
  private $lastName;

  /**
   * @var Profile
   * @ORM\OneToOne(targetEntity="AppBundle\Entity\Profile", mappedBy="user", cascade={"all"})
   */
  private $profile;

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getFirstName()
  {
    return $this->firstName;
  }

  /**
   * @param mixed $firstName
   */
  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;
  }

  /**
   * @return mixed
   */
  public function getOtherNames()
  {
    return $this->otherNames;
  }

  /**
   * @param mixed $otherNames
   */
  public function setOtherNames($otherNames)
  {
    $this->otherNames = $otherNames;
  }

  /**
   * @return mixed
   */
  public function getLastName()
  {
    return $this->lastName;
  }

  /**
   * @param mixed $lastName
   */
  public function setLastName($lastName)
  {
    $this->lastName = $lastName;
  }

  /**
   * Set profile
   *
   * @param Profile $profile
   *
   * @return User
   */
  public function setProfile(Profile $profile = null)
  {
    $this->profile = $profile;
    $profile->setUser($this);

    return $this;
  }

  /**
   * Get profile
   *
   * @return Profile
   */
  public function getProfile()
  {
    return $this->profile;
  }
}
