<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\{Factory, Generator};

abstract class BaseFixture extends Fixture
{
    protected Generator $faker;
    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        $this->generate($manager);
    }

    abstract protected function generate(ObjectManager $manager): void;

    protected function create(
        string $class,
        int $count,
        callable $callback,
        string|bool $reference = false
    ): void {
        foreach (range(1, $count) as $i) {
            $callback($object = new $class(), $i);
            $this->manager->persist($object);
            $reference && $this->addReference($reference.$i, $object);
        }
        $this->manager->flush();
    }

    protected function createFromArray(
        string $class,
        array $array,
        callable $callback,
        string|bool $reference = false
    ): void {
        foreach ($array as $key => $element) {
            $callback($object = new $class(), $element->value, $key);
            $this->manager->persist($object);
            $reference && $this->addReference($reference.$key, $object);
        }
        $this->manager->flush();
    }
}
