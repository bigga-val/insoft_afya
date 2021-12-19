<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
//            ->add('roles', ChoiceType::class,[
//                'choices'=>[
//                    //'Patient'=>'ROLE_PATIENT',
//                    'MEDECIN'=>'ROLE_MEDECIN',
//                ],
//                'expanded'=>true,
//                'multiple'=>true,
//                'label'=>'Role :'
//            ])

            ->add('email')
            ->add('password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
