<?php

namespace App\DataFixtures;

use App\Entity\Allergen;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AllergenFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $allergen_labels = [
            ['gluten', 'Produit à base de céréales'],
            ['crustacean', 'Produit à base de crustacées'],
            ['eggs', 'Produit à base d\'oeufs'],
            ['peanut', 'Produit à base d\'arachides'],
            ['fish', 'Produit à base de poissons'],
            ['soy', 'Produit à base de soja'],
            ['milk', 'Produit laitiers'],
            ['nut', 'Produit à base de fruits à coque'],
            ['celery', 'Produit à base de Céleri'],
            ['mustard', 'Produit à base de moutarde'],
            ['sesame', 'Produit à base de graines de sésame'],
            ['anhydride', 'Anhydride sulfureux et sulfites'],
            ['lupin', 'Produit à base de lupin'],
            ['mollusc', 'Produit à base de mollusques'],
        ];

        foreach($allergen_labels as $labels){
            $allergen = new Allergen();
            $allergen->setLabel($labels[0]);
            $allergen->setDisplayLabel($labels[1]);

            $this->addReference($labels[0], $allergen);

            $manager->persist($allergen);
        }

        $manager->flush();
    }
}
