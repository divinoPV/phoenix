<?php

namespace App\DataFixtures;

use App\Entity\Portfolio;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class PortfolioFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REFERENCE = 'portfolio_';

    public const NUMBER_ELEMENT = 21;

    protected function generate(ObjectManager $manager): void
    {
        $this->create(Portfolio::class, self::NUMBER_ELEMENT, function (Portfolio $portfolio) {
            $portfolio
                ->setName($this->faker->sentence())
                ->setResponsible($this->getReference(\rand(0, 1)
                    ? UserFixtures::REFERENCE['responsible_project'] . \rand(1, UserFixtures::NUMBER_ELEMENT['responsible_project'])
                    : UserFixtures::REFERENCE['responsible_customer'] . \rand(1, UserFixtures::NUMBER_ELEMENT['responsible_customer'])
                ))
            ;
        }, self::REFERENCE);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
