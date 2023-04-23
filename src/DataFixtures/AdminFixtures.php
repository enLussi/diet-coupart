<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder) {}

    public function load(ObjectManager $manager): void
    {

        //Modifier les valeurs pour générer un nouvel admin
        //Puis lancer la fixture avec
        //symfony console doctrine:fixtures:load --group=admin --append
        $admin = new Administrator();
        $admin->setEmail('admin@diet.fr');
        $admin->setLastname('Admin');
        $admin->setFirstname('Admin');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['admin'];
    }
}
