<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngrédientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ingredient_min = [
            ['Farine', $this->getReference('gluten')],
            ['Oeufs', $this->getReference('eggs') ],
            ['Sucre', null],
            ['Lait', $this->getReference('milk')],
            ['Beurre', $this->getReference('milk')],
            ['Levure chimique', null],
            ['Sel', null],
            ['Poivre', null],
            ['Huile d\'olive', null],
            ['Vinaigre balsamique', null],
            ['Poulet', null],
            ['Riz', $this->getReference('gluten')],
            ['Poivron', null],
            ['Oignon', null],
            ['Tomate', null],
            ['Concombre', null],
            ['Feta', $this->getReference('milk')],
            ['Olives noires', null],
            ['Persil', null],
            ['Menthe', null],
            ['Cumin', null]
        ];

        foreach($ingredient_min as $min) {
            $ingredient = new Ingredient();
            $ingredient->setLabel($min[0]);
            $ingredient->setAllergen($min[1]);

            $manager->persist($ingredient);
        }


        $manager->flush();
    }
}
