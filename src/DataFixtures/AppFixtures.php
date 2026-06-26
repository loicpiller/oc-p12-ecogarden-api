<?php

namespace App\DataFixtures;

use App\Entity\Tip;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['admin', 'Lyon', 'admin', ['ROLE_ADMIN']],
            ['alice', 'Paris', 'password', []],
            ['bob', 'Marseille', 'password', []],
        ];

        foreach ($users as [$username, $city, $plainPassword, $roles]) {
            $user = (new User())
                ->setUsername($username)
                ->setCity($city)
                ->setRoles($roles);
            $user->setPassword($this->hasher->hashPassword($user, $plainPassword));
            $manager->persist($user);
        }

        $tips = [
            ['Arrosez de préférence le matin pour limiter l\'évaporation.', [5, 6, 7, 8]],
            ['Plantez les tomates après les dernières gelées.', [4, 5]],
            ['Paillez le sol pour le protéger du froid.', [10, 11, 12]],
            ['Semez les radis, ils poussent vite.', [3, 4, 5, 9]],
            ['Taillez les arbres fruitiers pendant le repos végétatif.', [1, 2, 12]],
        ];

        foreach ($tips as [$text, $months]) {
            $manager->persist(
                (new Tip())->setText($text)->setMonths($months)
            );
        }

        $manager->flush();
    }
}
