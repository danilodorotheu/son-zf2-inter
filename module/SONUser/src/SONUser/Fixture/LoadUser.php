<?php

namespace SONUser\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;

use SONUser\Entity\User;

class LoadUser extends AbstractFixture {

    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setNome('Admin')
            ->setEmail('dev.marcio.pinheiro@gmail.com')
            ->setPassword('123')
            ->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setNome('Marcio Pinheiro')
            ->setEmail('mrciopnhro@gmail.com')
            ->setPassword('123')
            ->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setNome('Marta Lopes')
            ->setEmail('marta.25lopes@gmail.com')
            ->setPassword('123')
            ->setActive(true);
        $manager->persist($user);

        $manager->flush();
    }

}