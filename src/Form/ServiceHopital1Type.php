<?php

namespace App\Form;

use App\Entity\ServiceHopital;
use App\Repository\HopitalRepository;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ServiceHopital1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $hopitalrepo = HopitalRepository::class;
        $servicerepo = ServiceRepository::class;
        $builder
            ->add('createdBy')
            ->add('createdAt')
            ->add('status')
            ->add('serviceID')
            ->add('hopitalID')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServiceHopital::class,
        ]);
    }
}
