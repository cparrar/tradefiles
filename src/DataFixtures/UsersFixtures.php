<?php

    namespace App\DataFixtures;

    use App\Entity\Users;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;
    use Symfony\Component\DependencyInjection\ContainerAwareInterface;
    use Symfony\Component\DependencyInjection\ContainerInterface;

    /**
     * Class UsersFixtures
     *
     * @package App\DataFixtures
     */
    class UsersFixtures extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface {

        /**
         * @var ContainerInterface
         */
        private $container;

        /**
         * @param ContainerInterface|null $container
         */
        public function setContainer(ContainerInterface $container = null) {

            $this->container = $container;
        }

        /**
         * @param Users $users
         * @param null $password
         *
         * @return string
         */
        private function getGenericPassword(Users $users, $password = null) {

            $encoder = $this->container->get('security.password_encoder');
            return $encoder->encodePassword($users, $password);
        }

        /**
         * @param ObjectManager $manager
         */
        public function load(ObjectManager $manager) {

            $entity = new Users();
            $entity->setUsername('ITFXSX@GMAIL.COM');
            $entity->setFirstName('CARLOS');
            $entity->setLastName('C');
            $entity->setEmail('ITFXSX@GMAIL.COM');
            $entity->setRole('ROLE_USER');
            $entity->setPassword($this->getGenericPassword($entity, 'init2WINIT'));

            $manager->persist($entity);
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
