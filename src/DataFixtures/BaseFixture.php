<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\{Factory, Generator};

abstract class BaseFixture extends Fixture
{
    private ObjectManager $manager;

    protected Generator $faker;

    abstract protected function generate(ObjectManager $manager): void;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        $this->generate($manager);
    }

    protected function create(
        string $class,
        int $count,
        callable $callback,
        string|bool $reference = false
    ): void {
        foreach (range(1, $count) as $i):
            $object = new $class();
            $callback($object, $i);
            $this->manager->persist($object);
            $reference && $this->addReference($reference . $i, $object);
        endforeach;

        $this->manager->flush();
    }

    protected function createFromArray(
        string $class,
        array $array,
        callable $callback,
        string|bool $reference = false
    ): void {
        foreach ($array as $key => $element):
            $object = new $class();
            $callback($object, $element->value);
            $this->manager->persist($object);
            $reference && $this->addReference($reference . $key, $object);
        endforeach;

        $this->manager->flush();
    }
}
