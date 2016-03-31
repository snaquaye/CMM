<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MemberLoanType extends AbstractType
{
  /**
   * @var AuthorizationCheckerInterface
   */
  private $security;

  /**
   * @var EntityManager
   */
  private $entityManager;

  public function __construct(AuthorizationCheckerInterface $security, EntityManager $entityManager)
  {
    $this->security = $security;
    $this->entityManager = $entityManager;
  }

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('amount')
      ->add('duration', NumberType::class, [
        'label' => 'Duration (in months)'
      ]);

    $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
      $form = $event->getForm();

      if ($this->security->isGranted('ROLE_ADMIN')) {
        $form->add('dateIssued', HiddenType::class, [
          'disabled' => 'true',
        ]);
        $form->add('issuedBy', HiddenType::class, [
          'disabled' => true
        ]);
        $form->add('interestRate');
        $form->add('approvalStatus', ChoiceType::class, [
          'choices' => ['Pending' => 'Pending', 'Approved' => 'Approved', 'Disapproved' => 'Disapproved'],
          'placeholder' => ''
        ]);
      }
    });
  }

  /**
   * @param OptionsResolver $resolver
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Loan'
    ));
  }

  public function getName()
  {
    return 'loan_form';
  }
}
