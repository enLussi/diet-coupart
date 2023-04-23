<?php

namespace App\DataFixtures;

use App\Entity\Diet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DietFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $diet_type = [
            'Cétogène',
            'Sans lactose',
            'Sans gluten',
            'Végane',
            'Flexistariste',
            'Végétariste',
            'Pesco-Végétariste'
        ];

        foreach($diet_type as $label) {
            $diet = new Diet();
            $diet->setLabel($label);
            $manager->persist($diet);
        }

        $manager->flush();
    }
}
