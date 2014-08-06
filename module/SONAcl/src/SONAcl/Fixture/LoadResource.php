<?php

namespace SONAcl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use SONAcl\Entity\Resource;

class LoadResource extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $resource = new Resource();
        $resource->setNome('Posts');
        $manager->persist($resource);

        $resource = new Resource();
        $resource->setNome('Páginas');
        $manager->persist($resource);

        $resource = new Resource();
        $resource->setNome('Categorias');
        $manager->persist($resource);

        $resource = new Resource();
        $resource->setNome('Usuários');
        $manager->persist($resource);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder() {
        return 2;
    }
}