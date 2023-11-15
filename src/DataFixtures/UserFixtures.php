<?php

namespace App\DataFixtures;

use App\Entity\MembreTux;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$email,$plainPassword,$role]) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setPseudo("username");
            $roles = array();
            $roles[] = $role;
            $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();
    }
        private function getUserData()
        {
                yield [
                    'xhelozs@localhost',
                    'xhelozs',
                    'ROLE_ADMIN'
                ];
                yield [
                    'placeholder@localhost',
                    'placeholder',
                    'ROLE_USER'
                ];
                yield [
                    'nishogi@localhost',
                    'nishogi',
                    'ROLE_USER'
                ];
                yield [
                    'jouliet@localhost',
                    'jouliet',
                    'ROLE_USER'
                ];
                yield [
                    'xanode@localhost',
                    'xanode',
                    'ROLE_USER'
                ];
                yield [
                    'fauconk@localhost',
                    'fauconk',
                    'ROLE_USER'
                ];
                yield [
                    'izaia@localhost',
                    'izaia',
                    'ROLE_USER'
                ];
        }
}
