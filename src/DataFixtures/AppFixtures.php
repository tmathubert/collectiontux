<?php

namespace App\DataFixtures;

use App\Entity\CarteTux;
use App\Entity\User;
use App\Entity\ClasseurTux;
use App\Entity\MembreTux;
use App\Entity\VitrineTux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use function Symfony\Component\Clock\now;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
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
        yield ['zezezeroooo'];
        yield ['izaiaclass'];
        yield ['maverick'];
    }
    private static function cartesGenerator() {
        // CarteTux : type,desc,prix,classeurname
        yield ["Niveau 2","Switch",100,"nicowano"];
        yield ["Niveau 3","Routeur",200,"nicowano"];
        yield ["Mascotte","Tux",1000,"goat"];
        yield ["Niveau 1","Fibre",10,"Les cartes de Tim"];
    }
    public static function memberDataGenerator() {
        // MembreTux : usermail,pseudo,classeurname
        yield ["xhelozs@localhost","xhelozs","Les cartes de Tim"];
        yield ["placeholder@localhost","placeholder","goat"];
        yield ["xanode@localhost","xanode","fedoraaa"];
        yield ["nishogi@localhost","nishogi","nicowano"];
        yield ["jouliet@localhost","jouliet","zezezeroooo"];
        yield ["izaia@localhost","izaia","izaiaclass"];
        yield ["fauconk@localhost","fauconk","maverick"];
    }
    public static function vitrineDataGenerator() {
        // VitrineTux : name,[cartetypes],membrename,ispublic
        yield ["stylé !",["Niveau 1"],"xhelozs",true];
        yield ["test",["Mascotte","Niveau 3"],"xanode",false];
    }
    public function load(ObjectManager $manager){
        // Génération des classeurs
        foreach (self::classeurDataGenerator() as [$name]) {
            $classeur = new ClasseurTux();
            $classeur->setName($name);
        // Ajout du classeur à la file d'attente d'ajout à la base de données
            $manager->persist($classeur);
        // Création d'une référence pour chaque classeur par leur nom. $this->getReferance($name) permettra par la suite de récupérer le classeur.
            $this->addReference($name,$classeur);
        }

        foreach (self::cartesGenerator() as [$type, $desc, $prix, $classeurname]) {
        // Récupération du classeur dans lequel sera entreposée la carte
            $classeur = $this->getReference($classeurname);
        // Génération des cartes
            $carte = new CarteTux();
            $carte->setDescription($desc);
            $carte->setType($type);
            $carte->setPrix($prix);
            $carte->setDate(now());
        // Ajout de la carte au classeur
            $classeur->addCartestux($carte);
            $this->addReference($type,$carte);
        // Ajout de la carte à la file d'attente
            $manager->persist($carte);
        }

        foreach (self::memberDataGenerator() as [$usermail,$pseudo,$classeurname]) {
        // Génération des membres
            $membre = new MembreTux();
            $membre->setPseudo($pseudo);
        // Lien MembreTux<->User
            if ($usermail) {
                $user = $manager->getRepository(User::class)->findOneByEmail($usermail);
                $membre->setUser($user);
            }
        
        // Association d'un classeur au membre (ManyToOne)
            if ($classeurname != null) {
                $classeur = $this->getReference($classeurname);
                $classeurs = new ArrayCollection();
                $classeurs->add($classeur);
                $membre->setClasseurstux($classeurs);
                $classeur->setMembreTux($membre);
            }
        // Création d'une référence pour chaque membre par leur pseudo
            $this->addReference($pseudo,$membre);
        // Ajout du membre et mise à jour des classeurs dans la file d'attente
            $manager->persist($membre);
            $manager->persist($classeur);
        }

        foreach (self::vitrineDataGenerator() as [$name,$cartenames,$membername,$ispublic]) {
        // Génération des vitrines
            $vitrine = new VitrineTux();
            $vitrine->setName($name);
            $vitrine->setMembretux($this->getReference($membername));
            $vitrine->setIspublic($ispublic);
        // Ajout des cartes à la vitrine dans laquelle elles seront installées
            foreach ($cartenames as $cartename) {
                $vitrine->addCartesTux($this->getReference($cartename));
            }
        // Ajout des vitrines à la file d'attente
            $manager->persist($vitrine);
        }
        // Traitement de la file d'attente et ajout à la base de données
        $manager->flush();
    }
}