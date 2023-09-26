<?php

namespace App\DataFixtures;

use App\Entity\CarteTux;
use App\Entity\ClasseurTux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const ALL_TUX ='all-tux';
    private const TIM_TUX = 'tim-tux';
    /**
     * Generates initialization data for classeur : [title]
     * @return \\Generator
     */

    private static function classeurDataGenerator() {
        yield ["Toutes les cartes Tux",self::ALL_TUX];
        yield ["Les cartes de Tim",self::TIM_TUX];
    }
    private static function cartesGenerator() {
        yield [self::ALL_TUX, "Switch"];
        yield [self::ALL_TUX, "Routeur"];
        yield [self::ALL_TUX, "Tux"];
        yield [self::TIM_TUX, "Fibre"];
    }
    public function load(ObjectManager $manager){
        $classeurRepo = $manager->getRepository(ClasseurTux::class);
        foreach (self::classeurDataGenerator() as [$title,$classeurReference]) {
            $classeur = new ClasseurTux();
            $classeur->setName($title);
            $manager->persist($classeur);
            $manager->flush();
        }
        foreach (self::cartesGenerator() as [$classeurReference, $carteDesc]) {
            $classeur = $this->getReference($classeurReference);
            $carte = new CarteTux();
            $carte->setDescription($carteDesc);
            $manager->persist($classeur);
        }
        $manager->flush();
    }
}