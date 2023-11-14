<?php

namespace App\Form;

use App\Entity\ClasseurTux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseurTuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
                    ->add('name')
                    ->add('membreTux', null, [
                            'disabled'   => true,
                    ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClasseurTux::class,
        ]);
    }
}
