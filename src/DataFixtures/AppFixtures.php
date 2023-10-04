<?php

namespace App\DataFixtures;

use App\Entity\CarteTux;
use App\Entity\ClasseurTux;
use App\Entity\MembreTux;
use App\Entity\VitrineTux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use function Symfony\Component\Clock\now;

class AppFixtures extends Fixture
{
    /**
     * Generates initialization data for ClasseurTux,CarteTux and MembreTux
     * @return \\Generator
     */
    private static function classeurDataGenerator() {
        // ClasseurTux : name
        yield ['Les cartes de Tim'];
        yield ['nicowano'];
        yield ['fedoraaa'];
        yield ['goat'];
    }
    private static function cartesGenerator() {
        // CarteTux : type,desc,prix,classeurname
        yield ["Niveau 2","Switch",100,"nicowano"];
        yield ["Niveau 3","Routeur",200,"nicowano"];
        yield ["Mascotte","Tux",1000,"goat"];
        yield ["Niveau 1","Fibre",10,"Les cartes de Tim"];
    }
    public static function memberDataGenerator() {
        // MembreTux : role,pseudo,classeurname
        yield ["wifi","xhelozs","Les cartes de Tim"];
        yield ["vieux","placeholder","goat"];
        yield ["vieux","xanode","fedoraaa"];
        yield ["prez","nishogi","nicowano"];
        yield ["com","jouliet",null];
    }
    public static function vitrineDataGenerator() {
        // VitrineTux : name,[cartenames],membrename,ispublic
        yield ["stylé !",["Niveau 1"],"xhelozs",true];
        yield ["test",["Mascotte","Niveau 3"],"xanode",false];
    }
    public function load(ObjectManager $manager){
        foreach (self::classeurDataGenerator() as [$name]) {
            $classeur = new ClasseurTux();
            $classeur->setName($name);
            $manager->persist($classeur);
            $this->addReference($name,$classeur);
        }

        foreach (self::cartesGenerator() as [$type, $desc, $prix, $classeurname]) {
            $classeur = $this->getReference($classeurname);
            $carte = new CarteTux();
            $carte->setDescription($desc);
            $carte->setType($type);
            $carte->setPrix($prix);
            $carte->setDate(now());
            $classeur->addCartestux($carte);
            $this->addReference($type,$carte);
            $manager->persist($carte);
        }

        foreach (self::memberDataGenerator() as [$role,$pseudo,$classeurname]) {
            $membre = new MembreTux();
            $membre->setRole($role);
            $membre->setPseudo($pseudo);
            if ($classeurname != null) {
                $classeur = $this->getReference($classeurname);
                $membre->setClasseurtux($classeur);
                $classeur->setMembreTux($membre);
            }
            $this->addReference($pseudo,$membre);
            $manager->persist($membre);
            $manager->persist($classeur);
        }

        foreach (self::vitrineDataGenerator() as [$name,$cartenames,$membername,$ispublic]) {
            $vitrine = new VitrineTux();
            $vitrine->setName($name);
            $vitrine->setMembretux($this->getReference($membername));
            $vitrine->setIspublic($ispublic);
            foreach ($cartenames as $cartename) {
                $vitrine->addCartesTux($this->getReference($cartename));
            }
            $manager->persist($vitrine);
        }

        $manager->flush();
    }
}