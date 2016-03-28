<?php
/**
 * Created by PhpStorm.
 * User: SNAQuaye
 * Date: 3/28/2016
 * Time: 1:17 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('firstName')
      ->add('lastName')
      ->add('otherNames')
      ->add('username')
      ->add('email', EmailType::class)
      ->add('password', RepeatedType::class, [
        'type' => PasswordType::class,
        'invalid_message' => 'Password confirmation doesn\'t match',
        'options' => array('attr' => array('class' => 'password-field')),
        'required' => true,
        'first_options'  => array('label' => 'Password'),
        'second_options' => array('label' => 'Confirm Password'),
      ])
      ->add('profile', ProfileType::class);
  }

  public function getBlockPrefix()
  {
    return 'app_user_registration';
  }

  public function getName()
  {
    return $this->getBlockPrefix();
  }

  public function configureOptions(OptionsResolver $options)
  {
    $options->setDefaults([
      'data_class' => 'AppBundle\Entity\User'
    ]);
  }
}