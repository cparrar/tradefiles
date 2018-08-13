<?php

    namespace App\Service;

    use Symfony\Component\Filesystem\Filesystem;
    use Symfony\Component\Finder\Finder;

    /**
     * Class ReadLogService
     *
     * @package App\Service
     */
    class ReadLogService {

        /**
         * @var Filesystem
         */
        private $filesystem;

        /**
         * @var BagParameterService
         */
        private $parameter;

        /**
         * ReadLogService constructor.
         *
         * @param Filesystem $filesystem
         * @param BagParameterService $parameter
         */
        public function __construct(Filesystem $filesystem, BagParameterService $parameter) {

            $this->filesystem = $filesystem;
            $this->parameter = $parameter;
        }

        /**
         * Get  data file
         *
         * @param bool $raw
         *
         * @return array|bool|null
         */
        private function getDataFile(bool $raw = false) {

            $path = $this->parameter->get('log', null);

            if($this->filesystem->exists($path) != true):
                return [];
            endif;

            $finder = new Finder();
            $finder->files()->in($path)->name(sprintf('log.%s*', $this->parameter->getDate()))->sortByName();

            $iterator = $finder->getIterator();
            $iterator->rewind();
            $file = $iterator->current();

            return $raw == true ? $this->getReadFileRaw($file->getRealPath()) : $this->getReadFile($file->getRealPath());
        }

        /**
         * Get raw data
         *
         * @param string $path
         *
         * @return string
         */
        private function getReadFileRaw(string $path) {

            return trim(file_get_contents($path));
        }

        /**
         * Get data file
         *
         * @param string $path
         *
         * @return array|bool|null
         */
        private function getReadFile(string $path) {

            if($this->filesystem->exists($path) != true):
                return [];
            endif;

            $data = file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
            return is_array($data) ? array_reverse($data) : [];
        }

        /**
         * Get format string data
         *
         * @param string $string
         * @return array
         */
        private function getFormatString(string $string) {

            list($date, $code, $subcode, $message) = explode('|', $string);

            return [
                'date' => $date,
                'code' => $code,
                'sub-code' => $subcode,
                'message' => $message
            ];
        }

        /**
         * Get Raw Data
         *
         * @return string
         */
        public function getRaw() {

            return implode("\n", $this->getDataFile());
        }

        /**
         * Get Raw array limit data
         *
         * @param int $limit
         *
         * @return array
         */
        public function getRawLimited(int $limit = 10) {

            return implode("\n", array_slice($this->getDataFile(), 0, $limit));
        }

        /**
         * Get format array
         *
         * @return array
         */
        public function getArray() {

            $array = $this->getDataFile();
            return array_map([$this, 'getFormatString'], $array);
        }

        /**
         * Get format array limit data
         *
         * @param int $limit
         *
         * @return array
         */
        public function getArrayLimited(int $limit = 10) {

            $array = array_slice($this->getDataFile(), 0, $limit);
            return array_map([$this, 'getFormatString'], $array);
        }
    }