<?php

namespace App\Form;

use App\Entity\CarteTux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CarteTuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('imageFile',VichImageType::class,[
                'label' => 'Image de la carte',

            ])
            ->add('description')
            ->add('prix')
            ->add('date')
            ->add('classeurTux', null, [
                'disabled'   => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarteTux::class,
        ]);
    }
}
