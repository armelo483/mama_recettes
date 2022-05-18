<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 20; $i++) {

            $recipe = new Recipe();
            $this->faker = Factory::create();

            $recipe->setDescription($this->faker->text);
            $recipe->setTitle($this->faker->title);
            $recipe->setCreatedAt(\DateTimeImmutable::createFromMutable( $this->faker->dateTime ));
            $recipe->setUpdatedAt(\DateTimeImmutable::createFromMutable( $this->faker->dateTime ));
            $recipe->setImageUrl($this->faker->imageUrl(300, 300));
            $manager->persist($recipe);

        }

        $manager->flush();
    }
}
