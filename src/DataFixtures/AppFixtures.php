<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use App\Entity\Publication;
use App\Entity\Commentaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $utilisateurs = [];

        // Création d'un utilisateur administrateur
        $admin = new Utilisateur();
        $admin->setUsername('Administrateur de EcoConnect')
            ->setEmail('admin@ecoconnect.fr')
            ->setPassword('password') // Assurez-vous que vous utilisez le bon nom de méthode pour définir le mot de passe
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $utilisateurs[] = $admin;
        $manager->persist($admin);

        // Création de plusieurs utilisateurs fictifs
        for ($i = 0; $i < 10; $i++) {
            $user = new Utilisateur();
            $user->setUsername($this->faker->userName())
                ->setEmail($this->faker->email())
                ->setPassword('password') // Assurez-vous que vous utilisez le bon nom de méthode pour définir le mot de passe
                ->setRoles(['ROLE_USER']);

            $utilisateurs[] = $user;
            $manager->persist($user);
        }

        // Création de publications
        for ($i = 0; $i < 25; $i++) {
            $publication = new Publication();
            $publication->setDateTime($this->faker->dateTimeBetween('-1 year', 'now'))
                ->setLikesCount($this->faker->numberBetween(0, 100))
                ->setUserID($utilisateurs[$this->faker->numberBetween(0, count($utilisateurs) - 1)])
                ->setPostType('text')
                ->setPostContent($this->faker->text());

            $manager->persist($publication);

            // Ajout de commentaires pour chaque publication
            for ($j = 0; $j < $this->faker->numberBetween(0, 10); $j++) {
                $commentaire = new Commentaire();
                $commentaire->setDateTime($this->faker->dateTimeBetween($publication->getDateTime(), 'now'))
                    ->setUserID($utilisateurs[$this->faker->numberBetween(0, count($utilisateurs) - 1)])
                    ->setPostID($publication)
                    ->setContent($this->faker->text());

                $manager->persist($commentaire);
            }
        }

        $manager->flush();
    }
}
