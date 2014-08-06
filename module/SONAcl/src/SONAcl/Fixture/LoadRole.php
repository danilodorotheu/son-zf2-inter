<?php

namespace SONAcl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use SONAcl\Entity\Role;

class LoadRole extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $role = new Role();
        $role->setNome('visitante');
        $manager->persist($role);

        $visitante = $manager->getReference('SONAcl\Entity\Role', 1);
        $role = new Role();
        $role->setNome('registrado');
        $role->setParent($visitante);
        $manager->persist($role);

        $registrado = $manager->getReference('SONAcl\Entity\Role', 2);
        $role = new Role();
        $role->setNome('redator');
        $role->setParent($registrado);
        $manager->persist($role);

        $redator = $manager->getReference('SONAcl\Entity\Role', 3);
        $role = new Role();
        $role->setNome('editor');
        $role->setParent($redator);
        $manager->persist($role);

        $editor = $manager->getReference('SONAcl\Entity\Role', 4);
        $role = new Role();
        $role->setNome('admin');
        $role->setIsAdmin(true);
        $role->setParent($editor);
        $manager->persist($role);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder() {
        return 1;
    }
}