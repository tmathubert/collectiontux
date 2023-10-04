<?php

namespace App\DataFixtures;

use App\Entity\CarteTux;
use App\Entity\ClasseurTux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * Generates initialization data for classeur : [title]
     * @return \\Generator
     */

    private static function classeurDataGenerator() {
        // ClasseurTux : name
        yield ['Toutes les cartes Tux'];
        yield ['Les cartes de Tim'];
        yield ['Valou'];
    }
    private static function cartesGenerator() {
        // CarteTux : type,desc,prix,classeurname
        yield ["Matos","Switch",100,"Toutes les cartes Tux"];
        yield ["Matos","Routeur",200,"Toutes les cartes Tux"];
        yield ["Mascotte","Tux",1000,"Toutes les cartes Tux"];
        yield ["Matos","Fibre",10,"Les cartes de Tim"];
    }
    public function load(ObjectManager $manager){
        $classeurRepo = $manager->getRepository(ClasseurTux::class);
        foreach (self::classeurDataGenerator() as [$name]) {
            $classeur = new ClasseurTux();
            $classeur->setName($name);
            $manager->persist($classeur);
            //$this->addReference($name,$classeur);
        }
        /*foreach (self::cartesGenerator() as [$type, $desc, $prix, $classeurname]) {
            $classeur = $this->getReference($classeurname);
            $carte = new CarteTux();
            $carte->setDescription($desc);
            $carte->setType($type);
            $carte->setPrix($prix);
            //$manager->persist($carte);
            //$manager->flush();
        }*/
        $manager->flush();
    }
}