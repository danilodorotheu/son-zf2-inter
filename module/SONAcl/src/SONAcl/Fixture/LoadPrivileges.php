<?php

namespace SONAcl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use SONAcl\Entity\Privilege;

class LoadPrivileges extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $role = $manager->getReference('SONAcl\Entity\Role', 3);
        $resource = $manager->getReference('SONAcl\Entity\Resource', 1);
        $privilege = new Privilege();
        $privilege->setNome('Visualizar')
                ->setRole($role)
                ->setResource($resource);
        $manager->persist($privilege);

        $role = $manager->getReference('SONAcl\Entity\Role', 2);
        $resource = $manager->getReference('SONAcl\Entity\Resource', 2);
        $privilege = new Privilege();
        $privilege->setNome('Novo/Editar')
            ->setRole($role)
            ->setResource($resource);
        $manager->persist($privilege);

        $role = $manager->getReference('SONAcl\Entity\Role', 1);
        $resource = $manager->getReference('SONAcl\Entity\Resource', 4);
        $privilege = new Privilege();
        $privilege->setNome('Administrar')
            ->setRole($role)
            ->setResource($resource);
        $manager->persist($privilege);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder() {
        return 3;
    }
}