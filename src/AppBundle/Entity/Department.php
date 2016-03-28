<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Profile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartmentRepository")
 */
class Department
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
   * @ORM\Column(name="departmentName", type="string", length=20, unique=true)
   */
  private $departmentName;

  /**
   * @var ArrayCollection
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Profile", mappedBy="department")
   */
  private $profiles;

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
   * Set departmentName
   *
   * @param string $departmentName
   *
   * @return Department
   */
  public function setDepartmentName($departmentName)
  {
    $this->departmentName = $departmentName;

    return $this;
  }

  /**
   * Get departmentName
   *
   * @return string
   */
  public function getDepartmentName()
  {
    return $this->departmentName;
  }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->profiles = new ArrayCollection();
    }

    /**
     * Add profile
     *
     * @param Profile $profile
     *
     * @return Department
     */
    public function addProfile(Profile $profile)
    {
        $this->profiles[] = $profile;

        return $this;
    }

    /**
     * Remove profile
     *
     * @param Profile $profile
     */
    public function removeProfile(Profile $profile)
    {
        $this->profiles->removeElement($profile);
    }

    /**
     * Get profiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }
}
