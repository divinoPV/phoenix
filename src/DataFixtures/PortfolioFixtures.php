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
            $portfolio->setName($this->faker->sentence())
                ->setResponsible($this->getReference(UserFixtures::REFERENCE_RESPONSIBLE . rand(1, UserFixtures::NUMBER_ELEMENT)));
        }, self::REFERENCE);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
