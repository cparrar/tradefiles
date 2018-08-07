<?php

    namespace App\DataFixtures;

    use App\Entity\TypeParameters;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;

    /**
     * Class ParameterTypeFixture
     *
     * @package App\DataFixtures
     */
    class ParameterTypeFixture extends Fixture implements OrderedFixtureInterface {

        /**
         * @param ObjectManager $manager
         */
        public function load(ObjectManager $manager) {

            $array = ['DIRECTORY', 'CACHE', 'HTML', 'FORMAT'];

            foreach ($array AS $value):

                $entity = new TypeParameters();
                $entity->setName($value);

                $manager->persist($entity);
                $this->setReference(sprintf('TYPE_%s', $value), $entity);

            endforeach;

            $manager->flush();
        }

        /**
         * Get the order of this fixture
         *
         * @return integer
         */
        public function getOrder() {

            return 1;
        }
    }
