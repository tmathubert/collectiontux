<?php

namespace App\Form;

use App\Entity\VitrineTux;
use App\Repository\CarteTuxRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VitrineTuxType extends AbstractType
{
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
                //dump($options);
                $vitrine = $options['data'] ?? null;
                $member = $vitrine->getMembreTux();

                $builder
                        ->add('name')
                        ->add('ispublic')
                        ->add('membreTux', null, [
                                'disabled'   => true,
                        ])
                        ->add('cartesTux', null, [
                                'query_builder' => function (CarteTuxRepository $er) use ($member) {
                                                return $er->createQueryBuilder('o')
                                                ->leftJoin('o.classeurTux', 'i')
                                                ->andWhere('i.membreTux = :member')
                                                ->setParameter('member', $member)
                                                ;
                                        },
                                // avec 'by_reference' => false, sauvegarde les modifications
                                'by_reference' => false,
                                // classe pas obligatoire
                                //'class' => [Object]::class,
                                // permet sélection multiple
                                'multiple' => true,
                                // affiche sous forme de checkboxes
                                'expanded' => true
                                ])
                ;
        }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VitrineTux::class,
        ]);
    }
}
