<?php

    namespace App\Service;

    /**
     * Class FormatPathService
     *
     * @package App\Service
     */
    class FormatPathService {

        /**
         * @var CacheService
         */
        private $cache;

        /**
         * @var BagParameterService
         */
        private $parameter;

        /**
         * FormatPathService constructor.
         *
         * @param CacheService $cache
         * @param BagParameterService $parameter
         */
        function __construct(CacheService $cache, BagParameterService $parameter) {

            $this->cache = $cache;
            $this->parameter = $parameter;
        }

        /**
         * Get format path reading
         *
         * @return SearchPath|mixed|\Symfony\Component\Cache\CacheItem
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function get() {

            if($this->cache->has('cache_path')):
                return $this->cache->get('cache_path');
            else:
                $data = new SearchPath($this->parameter->get('directory'), sprintf('%s*', $this->parameter->getDate()));
                $this->cache->set('cache_path', $data->getArray(), $this->parameter->get('cache_path'));
                return $data->getArray();
            endif;
        }
    }