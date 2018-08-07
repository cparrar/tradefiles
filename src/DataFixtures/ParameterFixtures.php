<?php

    namespace App\DataFixtures;

    use App\Entity\Parameters;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;

    /**
     * Class ParameterFixtures
     *
     * @package App\DataFixtures
     */
    class ParameterFixtures extends Fixture implements OrderedFixtureInterface  {

        /**
         * @param ObjectManager $manager
         */
        public function load(ObjectManager $manager) {

            $array = [
                [
                    'name' => 'directory',
                    'title' => 'Change reading directory',
                    'value' => 'C:\Users\Desarrollo\Downloads\Analysis\Analysis',
                    'description' => 'Directory where the different subdirectories of the campaigns and the CSV files are for reading.',
                    'type' => $this->getReference('TYPE_DIRECTORY')
                ],
                [
                    'name' => 'cache_params',
                    'title' => 'Parameters cache',
                    'value' => '1',
                    'description' => 'You can change the expiration time of the cache that is generated from the different system configurations, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_CACHE')
                ],
                [
                    'name' => 'cache_path',
                    'title' => 'Directory reading cache',
                    'value' => '1',
                    'description' => 'It is the expiration time of the read cache of the configured directory, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_CACHE')
                ],
                [
                    'name' => 'cache_dashboard',
                    'title' => 'Information cache of general dashboards',
                    'value' => '1',
                    'description' => 'It is the expiration time of the cache of the reading of the different information files that are in each account, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_CACHE')
                ],
                [
                    'name' => 'cache_dashboard_account',
                    'title' => 'Account dashboard reading file cache',
                    'value' => '1',
                    'description' => 'It is the expiration time of the cache of the reading dashboard of the account and different campaigns, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_CACHE')
                ],
                [
                    'name' => 'cache_account_campaign',
                    'title' => 'Account campaign reading file cache',
                    'value' => '1',
                    'description' => 'It is the expiration time of the cache of the reading campaign of the account, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_CACHE')
                ],
                [
                    'name' => 'cache_account_trade',
                    'title' => 'Account trade reading file cache',
                    'value' => '1',
                    'description' => 'It is the expiration time of the cache of the reading trade of the account campaign, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_CACHE')
                ],
                [
                    'name' => 'vue_js_login_dashboard',
                    'title' => 'Login dashboard loading interval time',
                    'value' => '60',
                    'description' => 'It is the interval time that is generated between request and request for loading the dashboard data, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_HTML')
                ],
                [
                    'name' => 'time_interval_menu',
                    'title' => 'Menu update time',
                    'value' => '10',
                    'description' => 'It is the interval of update of the different data that are observed in the menu, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_HTML')
                ],
                [
                    'name' => 'time_interval_dashboard',
                    'title' => 'Dashboard update time',
                    'value' => '5',
                    'description' => 'It is the interval of update of the different data that are observed in the dashboard general, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_HTML')
                ],
                [
                    'name' => 'time_interval_account_dashboard',
                    'title' => 'Account Dashboard update time',
                    'value' => '5',
                    'description' => 'It is the interval of update of the different data that are observed in the dashboard of account, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_HTML')
                ],
                [
                    'name' => 'time_interval_account_campaign',
                    'title' => 'Account Campaign update time',
                    'value' => '5',
                    'description' => 'It is the interval of update of the different data that are observed in the campaign of account, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_HTML')
                ],
                [
                    'name' => 'time_interval_account_trade',
                    'title' => 'Account Campaign Trade update time',
                    'value' => '5',
                    'description' => 'It is the interval of update of the different data that are observed in the campaign trade of account, the configuration is in seconds.',
                    'type' => $this->getReference('TYPE_HTML')
                ],
            ];

            foreach ($array AS $row):

                $entity = new Parameters();
                foreach ($row AS $key => $value):
                    call_user_func_array([$entity, sprintf('set%s', ucfirst($key))], [$value]);
                endforeach;
                $manager->persist($entity);
            endforeach;

            $manager->flush();
        }

        /**
         * Get the order of this fixture
         *
         * @return integer
         */
        public function getOrder() {

            return 2;
        }
    }