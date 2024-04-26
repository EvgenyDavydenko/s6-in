<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\BookFactory;
use App\Factory\AuthorFactory;
use App\Factory\PublisherFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        PublisherFactory::createMany(4);
        AuthorFactory::createMany(6);

        BookFactory::createMany(20, function() {
            return [
                // each Post will have a random Category (chosen from those created above)
                'publisher' => PublisherFactory::random(),

                // each Post will have between 0 and 6 Tag's (chosen from those created above)
                'author' => AuthorFactory::randomRange(1, 3),
            ];
        });
    }
}
