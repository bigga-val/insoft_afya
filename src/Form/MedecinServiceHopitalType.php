<?php

namespace App\Form;

use App\Entity\MedecinServiceHopital;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinServiceHopitalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt')
            ->add('createBy')
            ->add('status')
            ->add('medecin')
            ->add('ServiceHopital')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MedecinServiceHopital::class,
        ]);
    }
}
