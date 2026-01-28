<?php

namespace App\DataFixtures;

use App\Entity\Painting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class PaintingFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        // Création de 20 œuvres célèbres avec techniques variées
        $paintings = [
            ['title' => 'La Nuit Étoilée', 'description' => 'Peinte depuis l\'asile de Saint-Rémy-de-Provence, cette œuvre représente un ciel nocturne tourbillonnant au-dessus d\'un village paisible. Les spirales lumineuses et les étoiles éclatantes créent un mouvement hypnotique qui capture l\'état émotionnel tourmenté de l\'artiste.', 'author' => 'Vincent van Gogh', 'height' => 73.7, 'width' => 92.1, 'technical' => 'Post-impressionnisme', 'image' => 'starry-night.jpg', 'created' => new \DateTimeImmutable('1889-01-01')],
            ['title' => 'La Joconde', 'description' => 'Portrait le plus célèbre au monde, cette œuvre fascine par le sourire énigmatique de la jeune femme et son regard qui semble suivre le spectateur. La technique du sfumato crée une atmosphère mystérieuse et intemporelle qui continue d\'intriguer les visiteurs du Louvre.', 'author' => 'Leonardo da Vinci', 'height' => 77.0, 'width' => 53.0, 'technical' => 'Renaissance', 'image' => 'mona-lisa.jpg', 'created' => new \DateTimeImmutable('1503-01-01')],
            ['title' => 'Le Cri', 'description' => 'Icône de l\'expressionnisme moderne, cette œuvre capture l\'angoisse existentielle à travers une figure déformée hurlant sur un pont. Les couleurs flamboyantes du ciel et les lignes ondulantes créent une sensation de chaos intérieur et de désespoir universel.', 'author' => 'Edvard Munch', 'height' => 91.0, 'width' => 73.5, 'technical' => 'Expressionnisme', 'image' => 'the-scream.jpg', 'created' => new \DateTimeImmutable('1893-01-01')],
            ['title' => 'Guernica', 'description' => 'Œuvre monumentale créée en réponse au bombardement de la ville basque de Guernica pendant la guerre civile espagnole. Les figures déformées, le chaos et la palette monochrome transmettent l\'horreur de la guerre et la souffrance des civils innocents.', 'author' => 'Pablo Picasso', 'height' => 349.3, 'width' => 776.6, 'technical' => 'Cubisme', 'image' => 'guernica.jpg', 'created' => new \DateTimeImmutable('1937-01-01')],
            ['title' => 'Les Tournesols', 'description' => 'Série emblématique de natures mortes représentant des tournesols dans un vase. Les coups de pinceau épais et les jaunes éclatants témoignent de l\'amour de l\'artiste pour cette fleur qu\'il considérait comme un symbole de gratitude et d\'optimisme.', 'author' => 'Vincent van Gogh', 'height' => 92.1, 'width' => 73.0, 'technical' => 'Post-impressionnisme', 'image' => 'sunflowers.jpg', 'created' => new \DateTimeImmutable('1888-01-01')],
            ['title' => 'La Jeune Fille à la Perle', 'description' => 'Souvent appelée la "Joconde du Nord", ce portrait intime capture le regard direct et lumineux d\'une jeune fille portant une perle. L\'usage magistral de la lumière et du fond sombre crée une profondeur émotionnelle saisissante.', 'author' => 'Johannes Vermeer', 'height' => 44.5, 'width' => 39.0, 'technical' => 'Baroque', 'image' => 'girl-pearl.jpg', 'created' => new \DateTimeImmutable('1665-01-01')],
            ['title' => 'La Création d\'Adam', 'description' => 'Fresque monumentale ornant le plafond de la Chapelle Sixtine au Vatican. L\'instant où les doigts de Dieu et d\'Adam se touchent presque est devenu l\'une des images les plus iconiques de l\'art occidental, symbolisant la transmission de la vie divine à l\'humanité.', 'author' => 'Michel-Ange', 'height' => 280.0, 'width' => 570.0, 'technical' => 'Renaissance', 'image' => 'creation-adam.jpg', 'created' => new \DateTimeImmutable('1512-01-01')],
            ['title' => 'Les Demoiselles d\'Avignon', 'description' => 'Œuvre révolutionnaire qui marque la naissance du cubisme. Les cinq figures féminines aux visages masqués et aux corps fragmentés rompent radicalement avec les conventions de la perspective traditionnelle, ouvrant la voie à l\'art moderne.', 'author' => 'Pablo Picasso', 'height' => 243.9, 'width' => 233.7, 'technical' => 'Cubisme', 'image' => 'demoiselles.jpg', 'created' => new \DateTimeImmutable('1907-01-01')],
            ['title' => 'Le Baiser', 'description' => 'Chef-d\'œuvre de l\'Art Nouveau représentant un couple enlacé dans une étreinte passionnée. Les motifs géométriques dorés, les ornements floraux et l\'utilisation de feuilles d\'or créent une atmosphère de sensualité mystique et d\'amour éternel.', 'author' => 'Gustav Klimt', 'height' => 180.0, 'width' => 180.0, 'technical' => 'Art Nouveau', 'image' => 'kiss.jpg', 'created' => new \DateTimeImmutable('1908-01-01')],
            ['title' => 'La Persistance de la Mémoire', 'description' => 'Œuvre surréaliste emblématique représentant des montres molles se liquéfiant dans un paysage désertique. Cette image onirique explore les concepts du temps, de la mémoire et de la réalité, créant un univers où les lois de la physique sont suspendues.', 'author' => 'Salvador Dalí', 'height' => 24.0, 'width' => 33.0, 'technical' => 'Surréalisme', 'image' => 'persistence.jpg', 'created' => new \DateTimeImmutable('1931-01-01')],
            ['title' => 'La Naissance de Vénus', 'description' => 'Chef-d\'œuvre de la Renaissance représentant la déesse Vénus émergeant des flots marins sur une coquille. La grâce éthérée de la composition, les couleurs délicates et l\'idéalisation de la beauté féminine incarnent l\'esprit humaniste de la Renaissance florentine.', 'author' => 'Sandro Botticelli', 'height' => 172.5, 'width' => 278.9, 'technical' => 'Renaissance', 'image' => 'venus.jpg', 'created' => new \DateTimeImmutable('1485-01-01')],
            ['title' => 'Les Iris', 'description' => 'Nature morte vibrante capturant la beauté délicate des fleurs d\'iris aux tons bleus et violets profonds. Peinte dans le jardin de l\'asile de Saint-Rémy, cette œuvre témoigne de la capacité de l\'artiste à trouver la beauté même dans les moments les plus sombres.', 'author' => 'Vincent van Gogh', 'height' => 71.0, 'width' => 93.0, 'technical' => 'Post-impressionnisme', 'image' => 'iris.jpg', 'created' => new \DateTimeImmutable('1889-01-01')],
            ['title' => 'Le Déjeuner sur l\'Herbe', 'description' => 'Œuvre scandaleuse qui a choqué le Paris du XIXe siècle en représentant une femme nue déjeunant avec des hommes habillés dans un parc. Cette toile a remis en question les conventions académiques et a ouvert la voie au mouvement impressionniste.', 'author' => 'Édouard Manet', 'height' => 208.0, 'width' => 264.5, 'technical' => 'Réalisme', 'image' => 'dejeuner.jpg', 'created' => new \DateTimeImmutable('1863-01-01')],
            ['title' => 'La Danse', 'description' => 'Cinq figures nues dansant en cercle dans un paysage minimaliste aux couleurs primaires éclatantes. Cette œuvre célèbre la joie de vivre et l\'énergie primitive à travers des formes simplifiées et des couleurs intenses caractéristiques du fauvisme.', 'author' => 'Henri Matisse', 'height' => 260.0, 'width' => 391.0, 'technical' => 'Fauvisme', 'image' => 'dance.jpg', 'created' => new \DateTimeImmutable('1910-01-01')],
            ['title' => 'Olympia', 'description' => 'Portrait provocateur d\'une courtisane parisienne allongée nue, regardant le spectateur avec assurance. Cette œuvre a déclenché un scandale en confrontant directement le public aux réalités de la société parisienne et en défiant les codes de la nudité académique.', 'author' => 'Édouard Manet', 'height' => 130.5, 'width' => 190.0, 'technical' => 'Réalisme', 'image' => 'olympia.jpg', 'created' => new \DateTimeImmutable('1863-01-01')],
            ['title' => 'Le Jardin des Délices', 'description' => 'Triptyque énigmatique rempli de créatures fantastiques, de scènes sensuelles et de symboles mystérieux. Cette œuvre complexe explore les thèmes du paradis, de la tentation terrestre et de l\'enfer à travers un univers onirique d\'une richesse visuelle extraordinaire.', 'author' => 'Jérôme Bosch', 'height' => 220.0, 'width' => 389.0, 'technical' => 'Renaissance', 'image' => 'jardin.jpg', 'created' => new \DateTimeImmutable('1510-01-01')],
            ['title' => 'L\'École d\'Athènes', 'description' => 'Fresque monumentale représentant les plus grands philosophes et savants de l\'Antiquité grecque réunis sous une architecture grandiose. Au centre, Platon et Aristote symbolisent les deux grandes traditions philosophiques qui ont façonné la pensée occidentale.', 'author' => 'Raphaël', 'height' => 500.0, 'width' => 770.0, 'technical' => 'Renaissance', 'image' => 'athenes.jpg', 'created' => new \DateTimeImmutable('1511-01-01')],
            ['title' => 'Les Nymphéas', 'description' => 'Série monumentale de peintures représentant l\'étang aux nymphéas du jardin de Giverny. Les reflets changeants de l\'eau, les nénuphars flottants et les jeux de lumière créent une atmosphère contemplative qui transcende la simple représentation de la nature.', 'author' => 'Claude Monet', 'height' => 200.0, 'width' => 425.0, 'technical' => 'Impressionnisme', 'image' => 'nympheas.jpg', 'created' => new \DateTimeImmutable('1916-01-01')],
            ['title' => 'Impression, Soleil Levant', 'description' => 'Œuvre fondatrice de l\'impressionnisme qui a donné son nom au mouvement. Cette vue brumeuse du port du Havre au lever du soleil capture l\'essence fugitive de la lumière et de l\'atmosphère, privilégiant l\'impression visuelle sur la précision des détails.', 'author' => 'Claude Monet', 'height' => 48.0, 'width' => 63.0, 'technical' => 'Impressionnisme', 'image' => 'impression.jpg', 'created' => new \DateTimeImmutable('1872-01-01')],
            ['title' => 'La Liberté Guidant le Peuple', 'description' => 'Allégorie puissante commémorant la révolution de juillet 1830 en France. La figure de la Liberté, à la fois déesse antique et femme du peuple, brandit le drapeau tricolore et guide les insurgés à travers les barricades, incarnant les idéaux républicains de liberté et de fraternité.', 'author' => 'Eugène Delacroix', 'height' => 260.0, 'width' => 325.0, 'technical' => 'Romantisme', 'image' => 'liberte.jpg', 'created' => new \DateTimeImmutable('1830-01-01')]
        ];

        foreach ($paintings as $data) {
            $painting = new Painting();
            $painting->setTitle($data['title']);
            $painting->setDescription($data['description']);
            $painting->setAuthor($data['author']);
            $painting->setHeight($data['height']);
            $painting->setWidth($data['width']);
            $painting->setTechnical($data['technical']);
            $painting->setImage($data['image']);
            $painting->setCreated($data['created']);
            
            $slug = $this->slugger->slug($data['title'])->lower();
            $painting->setSlug($slug);

            $manager->persist($painting);
        }

        $manager->flush();
    }
}
