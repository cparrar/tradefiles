<?php

    namespace App\Service;

    use Doctrine\ORM\EntityManager;
    use Symfony\Component\HttpFoundation\ParameterBag;

    /**
     * Class BagParameterService
     *
     * @package App\Service
     */
    class BagParameterService extends ParameterBag {

        /**
         * @var CacheService
         */
        private $cache;

        /**
         * @var string
         */
        private $environment;

        /**
         * BagParameterService constructor.
         *
         * @param EntityManager $entityManager
         * @param CacheService $cache
         * @param string $environment
         *
         * @throws \Psr\Cache\InvalidArgumentException
         */
        function __construct(EntityManager $entityManager, CacheService $cache, string $environment) {

            $this->cache = $cache;
            $this->environment = $environment;
            parent::__construct($this->getQueryParams($entityManager));
        }

        /**
         * Return current date
         *
         * @return false|string
         */
        public function getDate() {

            return $this->environment == 'dev' ? '20180706' : date($this->get('date_format'));
        }

        /**
         * Get all params from db
         *
         * @param EntityManager $entityManager
         *
         * @return array
         * @throws \Psr\Cache\InvalidArgumentException
         */
        private function getQueryParams(EntityManager $entityManager) {

            if($this->cache->has('cache_params')):
                return $this->cache->get('cache_params');
            else:
                $list = [];
                $query = $entityManager->getRepository('App:Parameters')->findAll();

                if(count($query) > 0):
                    foreach ($query AS $array):
                        $list[$array->getName()] = $array->getValue();
                    endforeach;
                endif;
                $this->cache->set('cache_params', $list, $list['cache_params']);

                return $list;
            endif;
        }
    }