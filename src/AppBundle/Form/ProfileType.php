<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProfileType extends AbstractType
{
  /**
   * @var AuthorizationCheckerInterface
   */
  private $security;

  /**
   * @var EntityManager
   */
  private $em;

  /**
   * @param AuthorizationCheckerInterface $security
   * @param EntityManager $em
   */
  public function __construct(AuthorizationCheckerInterface $security, EntityManager $em)
  {
    $this->security = $security;
    $this->em = $em;
  }

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('dateOfRegistration', DateType::class)
      ->add('dateOfBirth', BirthdayType::class)
      ->add('maritalStatus', ChoiceType::class, [
        'choices' => ['Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced'],
        'placeholder'  => ''
      ])
      ->add('gender', ChoiceType::class, [
        'choices' => ['Male' => 'Male', 'Female' => 'Female'],
        'placeholder'  => ''
      ])
      ->add('address')
      ->add('phone')
      ->add('isQualified')
      ->add('state')
      ->add('annualIncome')
      ->add('netWorth')
      ->add('creditRating')
      ->add('department', EntityType::class, [
        'class' => 'AppBundle\Entity\Department',
        'choice_label' => 'departmentName',
        'placeholder' => ''
      ])
      ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        $form = $event->getForm();

        if (!$this->security->isGranted('ROLE_ADMIN')) {
          $form->remove('isQualified')->remove('creditRating');
        }
      })
      ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
        $em = $this->em;

        $form = $event->getForm();

        $qb = $em->createQueryBuilder();
        $query = $qb->select('count(d.id)')
          ->from('AppBundle:Department', 'd')
          ->getQuery();

        $departmentCount = $query->getSingleScalarResult();

        if (!$departmentCount) {
          $form->remove('department');
        }
      });
  }

  /**
   * @param OptionsResolver $resolver
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Profile'
    ));
  }

  public function getName()
  {
    return 'profile_form';
  }
}
