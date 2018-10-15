<?php

    namespace App\Service;


    /**
     * Class ParamsConstruct
     *
     * @package App\Service
     */
    class ParamsConstruct {

        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $directory;

        /**
         * @var string
         */
        private $path;

        /**
         * @var bool
         */
        private $isDir;

        /**
         * @var bool
         */
        private $isFile;

        /**
         * @var null
         */
        private $fileName;

        /**
         * @var array|null
         */
        private $content;

        /**
         * @var array
         */
        private $params;

        /**
         * ParamsConstruct constructor.
         *
         * @param string $name
         * @param string $directory
         * @param string $path
         * @param bool $isDir
         * @param bool $isFile
         * @param null $content
         */
        function __construct(string $name, string $directory, string $path, bool $isDir = true, bool $isFile = false, $content = null, $fileName = null) {

            $this->name = $name;
            $this->directory = $directory;
            $this->path = $path;
            $this->isDir = $isDir;
            $this->isFile = $isFile;
            $this->fileName = $fileName;
            $this->content = $content;
            $array = get_object_vars($this);
            array_pop($array);
            $this->params = $array;
        }

        /**
         * @return array
         */
        public function getArray(): array {

            return $this->params;
        }

        /**
         * @return string
         */
        public function getName(): string {

            return $this->name;
        }

        /**
         * @param string $name
         * @return ParamsConstruct
         */
        public function setName(string $name): ParamsConstruct {

            $this->name = $name;
            return $this;
        }

        /**
         * @return string
         */
        public function getDirectory(): string {

            return $this->directory;
        }

        /**
         * @param string $directory
         * @return ParamsConstruct
         */
        public function setDirectory(string $directory): ParamsConstruct {

            $this->directory = $directory;
            return $this;
        }

        /**
         * @return string
         */
        public function getPathName(): string {

            return $this->pathName;
        }

        /**
         * @param string $pathName
         * @return ParamsConstruct
         */
        public function setPathName(string $pathName): ParamsConstruct {

            $this->pathName = $pathName;
            return $this;
        }

        /**
         * @return bool
         */
        public function isDir(): bool {

            return $this->isDir;
        }

        /**
         * @param bool $isDir
         * @return ParamsConstruct
         */
        public function setIsDir(bool $isDir): ParamsConstruct {

            $this->isDir = $isDir;
            return $this;
        }

        /**
         * @return bool
         */
        public function isFile(): bool {

            return $this->isFile;
        }

        /**
         * @param bool $isFile
         * @return ParamsConstruct
         */
        public function setIsFile(bool $isFile): ParamsConstruct {

            $this->isFile = $isFile;
            return $this;
        }

        /**
         * @return array|null
         */
        public function getContent(): ?array {

            return $this->content;
        }

        /**
         * @param array|null $content
         * @return ParamsConstruct
         */
        public function setContent(?array $content): ParamsConstruct {

            $this->content = $content;
            return $this;
        }
    }