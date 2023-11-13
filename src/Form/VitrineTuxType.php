<?php

namespace App\Form;

use App\Entity\VitrineTux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VitrineTuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ispublic')
            ->add('name')
            ->add('cartesTux')
            ->add('membretux')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VitrineTux::class,
        ]);
    }
}
