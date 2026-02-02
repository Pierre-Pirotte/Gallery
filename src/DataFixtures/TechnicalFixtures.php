<?php

namespace App\DataFixtures;

use App\Entity\Technical;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TechnicalFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $techniques = [
            'Huile sur toile',
            'Huile sur bois',
            'Tempera et pastel sur carton',
            'Fresque',
            'Huile et feuilles d\'or sur toile',
            'Tempera sur toile',
            'Acrylique sur toile',
            'Aquarelle sur papier',
            'Encre sur papier',
            'Généré par IA'
        ];

        foreach ($techniques as $techniqueName) {
            $technical = new Technical();
            $technical->setName($techniqueName);
            $manager->persist($technical);
            
            // Créer une référence pour l'utiliser dans PaintingFixtures
            $this->addReference('technical_' . $techniqueName, $technical);
        }

        $manager->flush();
    }
}
