<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Post-impressionnisme',
            'Renaissance',
            'Expressionnisme',
            'Cubisme',
            'Baroque',
            'Art Nouveau',
            'Surréalisme',
            'Réalisme',
            'Fauvisme',
            'Impressionnisme',
            'Romantisme',
            'Néoclassisme',
            'Symbolisme',
            'Art abstrait',
            'ImageIA'
        ];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            
            // Créer une référence pour l'utiliser dans PaintingFixtures
            $this->addReference('category_' . $categoryName, $category);
        }

        $manager->flush();
    }
}
