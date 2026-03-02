<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly PasswordHasherFactoryInterface $passwordHasherFactory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $amsterdam = (new Conference())
            ->setCity('Amsterdam')
            ->setYear('2019')
            ->setIsInternational(true);
        $manager->persist($amsterdam);

        $paris = (new Conference())
            ->setCity('Paris')
            ->setYear('2020')
            ->setIsInternational(false);
        $manager->persist($paris);

        $comment1 = new Comment();
        $comment1->setConference($amsterdam);
        $comment1->setAuthor('Fabien');
        $comment1->setEmail('fabien@example.com');
        $comment1->setText('This was a great conference.');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setConference($amsterdam);
        $comment2->setAuthor('Lucas');
        $comment2->setEmail('lucas@example.com');
        $comment2->setText('I think this one is going to be moderated.');
        $manager->persist($comment2);

        $admin = (new Admin())
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername('admin')
            ->setPassword($this->passwordHasherFactory->getPasswordHasher(Admin::class)->hash('admin'));
        $manager->persist($admin);

        $manager->flush();
    }
}
