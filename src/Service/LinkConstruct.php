<?php

    namespace App\Service;

    /**
     * Class LinkConstruct
     *
     * @package App\Service
     */
    class LinkConstruct {

        /**
         * @var string
         */
        private $name;

        /**
         * @var bool
         */
        private $primary;

        /**
         * @var null
         */
        private $url;

        /**
         * @var null
         */
        private $content;

        /**
         * @var array
         */
        private $params;

        /**
         * LinkConstruct constructor.
         *
         * @param string $name
         * @param bool $primary
         * @param null $url
         * @param null $content
         */
        function __construct(string $name, bool $primary, $url = null, $content = null) {

            $this->name = $name;
            $this->primary = $primary;
            $this->url = is_null($url) ? 'javascript:;' : $url;
            $this->content = $content;

            $array = get_object_vars($this);
            array_pop($array);
            $this->params = $array;
        }

        /**
         * Get params link
         *
         * @return array
         */
        public function getArray() {

            return $this->params;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @param string $name
         */
        public function setName(string $name): void
        {
            $this->name = $name;
        }

        /**
         * @return bool
         */
        public function isPrimary(): bool
        {
            return $this->primary;
        }

        /**
         * @param bool $primary
         */
        public function setPrimary(bool $primary): void
        {
            $this->primary = $primary;
        }

        /**
         * @return null
         */
        public function getUrl()
        {
            return $this->url;
        }

        /**
         * @param null $url
         */
        public function setUrl($url): void
        {
            $this->url = $url;
        }

        /**
         * @return null
         */
        public function getContent()
        {
            return $this->content;
        }

        /**
         * @param null $content
         */
        public function setContent($content): void
        {
            $this->content = $content;
        }
    }