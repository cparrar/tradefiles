<?php

    namespace App\Service;

    use Symfony\Component\HttpFoundation\ParameterBag;

    /**
     * Class BagData
     *
     * @package App\Service
     */
    class BagData extends ParameterBag {

        /**
         * BagData constructor.
         *
         * @param array $parameters
         */
        public function __construct(array $parameters = array()) {

            parent::__construct($parameters);
        }

        /**
         * Validate is array data
         *
         * @param null $key
         *
         * @return bool
         */
        public function isArray($key = null) {

            return $this->has($key) ? is_array($this->get($key)) : false;
        }

        /**
         * Get a instance BagData
         *
         * @param null $key
         *
         * @return BagData|null
         */
        public function getInstance($key = null) {

            if($this->has($key)):
                return $this->isArray($key) ? new self($this->get($key)) : null;
            endif;

            return null;
        }

        /**
         * Get a name
         *
         * @return mixed|null
         */
        public function getName() {

            return $this->get('name');
        }

        /**
         * Get Directory
         *
         * @return mixed
         */
        public function getDirectory() {

            return $this->get('directory');
        }

        /**
         * Get path
         *
         * @return mixed
         */
        public function getPath() {

            return $this->get('path');
        }

        /**
         * is directory
         *
         * @return boolean
         */
        public function isDir() {

            return $this->get('isDir', false);
        }

        /**
         * is file
         *
         * @return mixed
         */
        public function isFile() {

            return $this->get('isFile', false);
        }

        /**
         * Get content
         *
         * @return BagData|null
         */
        public function getContent() {

            return $this->getInstance('content');
        }
    }