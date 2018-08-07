<?php

    namespace App\Service;

    use Symfony\Component\Cache\Adapter\FilesystemAdapter;
    use Symfony\Component\Filesystem\Filesystem;

    /**
     * Class CacheService
     *
     * @package App\Services
     */
    class CacheService {

        /**
         * @var FilesystemAdapter
         */
        private $cache;

        /**
         * CacheService constructor.
         *
         * @param string $namespace
         */
        public function __construct(string $namespace) {

            $this->cache = new FilesystemAdapter($namespace);
        }

        /**
         * Return validate exist cache key
         *
         * @param string $key
         * @return bool
         */
        public function has(string $key): bool {

            return $this->cache->hasItem($key);
        }

        /**
         * Get data saved in cache
         *
         * @param string|array $key
         *
         * @return mixed|\Symfony\Component\Cache\CacheItem
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function get($key = null) {

            return $this->cache->getItem($key)->get();
        }

        /**
         * Set cache
         *
         * @param string $key
         * @param null|int|array|string|boolean $data
         * @param int $expires seconds
         *
         * @return bool
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function set(string $key, $data = null, int $expires = 60): bool {

            $cache = $this->cache->getItem($key);
            $cache->set($data);
            $cache->expiresAfter($expires);

            return $this->cache->save($cache);
        }

        /**
         * delete key cache
         *
         * @param string $key
         *
         * @return bool
         */
        public function remove(string $key): bool {

            return $this->cache->deleteItem($key);
        }

        /**
         * Delete multiples keys cache
         *
         * @param array $keys
         * @return bool
         */
        public function removeKeys(array $keys = []) {

            return $this->cache->deleteItems($keys);
        }

        /**
         * Clear cache
         *
         * @return bool
         */
        public function clear() {

            return $this->cache->clear();
        }
    }