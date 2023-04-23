<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class PatientFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder) {}

    public function load(ObjectManager $manager): void
    {

        // Génère des infos aléatoires pour les tests avec la base de données
        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <= 5; $usr++) {
            $user = new Patient();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ', '',$faker->postcode));
            $user->setCity($faker->city);
            $user->setPhone($faker->phoneNumber);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'patient')
            );
            $user->setRoles(['ROLE_PATIENT']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
