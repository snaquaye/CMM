<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOfRegistration', DateTimeType::class)
            ->add('dateOfBirth', BirthdayType::class)
            ->add('maritalStatus')
            ->add('gender')
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
              'empty_data' => ''
            ])
        ;
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
}
