<?php
/**
 * Created by PhpStorm.
 * User: SNAQuaye
 * Date: 3/29/2016
 * Time: 3:02 AM
 */

namespace AppBundle\EventListener;


use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FOSRegistrationListener implements EventSubscriberInterface
{

  /**
   * @var EntityManager
   */
  private $em;

  /**
   * @var UserManagerInterface
   */
  private $userManager;

  /**
   * @param EntityManager $em
   * @param UserManagerInterface $userManager
   */
  public function __construct(EntityManager $em, UserManagerInterface $userManager)
  {
    $this->em = $em;
    $this->userManager = $userManager;
  }

  /**
   * @return array
   */
  public static function getSubscribedEvents()
  {
    return [
      FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
    ];
  }

  /**
   * @param FormEvent $event
   */
  public function onRegistrationSuccess(FormEvent $event)
  {
    $user = $event->getForm()->getData();

    $qb = $this->em->createQueryBuilder();
    $query = $qb->select('count(u.id)')
      ->from('AppBundle:User', 'u')
      ->getQuery();

    $userCount = $query->getSingleScalarResult();

    if ($userCount > 0) {
      $user->addRole('ROLE_USER');
    } else {
      $user->addRole('ROLE_ADMIN');
    }

    $this->userManager->updateUser($user);
  }
}