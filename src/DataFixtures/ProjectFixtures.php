<?php
namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\User;
use DateTime; // Don't forget to import DateTime
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $currentDateTime = new DateTime();
        $endDateTime = (clone $currentDateTime)->modify('+10 days');

        for ($i = 0; $i < 5; $i++) {
//            $user = new User();
//            $user->setName($faker->name());

            $project = new Project();
            $project->setName("project ".$i);
            $project->setDescription($faker->text());
            $project->setType($faker->mimeType());
            $project->setStatus(0);
            $project->setAddedDate($currentDateTime);
            $project->setEndDate($endDateTime);
            $project->setUserStatus(0);
//            $project->setUser($user);

            $manager->persist($project);
//            $manager->persist($user);
        }

        $manager->flush();
    }
}
