<?php

    namespace App\Service;

    use Symfony\Component\Filesystem\Filesystem;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

    /**
     * Class ReadCsvService
     *
     * @package App\Services
     */
    class FormatReadFileService {

        /**
         * @var Filesystem
         */
        private $filesystem;

        /**
         * @var array
         */
        private $headers = [];

        /**
         * @var array
         */
        private $data = [];

        /**
         * ReadCsvService constructor.
         *
         * @param Filesystem $filesystem
         */
        public function __construct(Filesystem $filesystem) {

            $this->filesystem = $filesystem;
        }

        /**
         * Generate read and format content file
         *
         * @param string $file
         *
         * @return $this
         */
        public function readFile(string $file): self {

            if($this->filesystem->exists($file) == false):
                throw new NotFoundHttpException('File not found');
            endif;

            $this->setFormatData($file);
            return $this;
        }

        /**
         * Extract a slice of the array
         *
         * @param int $start
         * @param int $end
         *
         * @return array
         */
        public function slice(int $start = 0, int $end = 3): array {

            return array_slice($this->data, $start, $end);
        }

        /**
         * Split an array into chunks
         *
         * @param int $size
         *
         * @return array
         */
        public function chunk(int $size = 2) {

            return array_chunk($this->data, $size);
        }

        /**
         * Get data
         *
         * @return array
         */
        public function getData(): array {

            return $this->data;
        }

        /**
         * Get Headers
         *
         * @return array
         */
        public function getHeaders(): array {

            return $this->headers;
        }

        /**
         * Generate format and set variables
         *
         * @param string $file
         */
        private function setFormatData(string $file) {

            $data = $this->setFormatContent($file);

            $this->headers = count($data) > 0 ? $data[0] : [];
            unset($data[0]);

            $this->data = array_values($data);
            unset($data);
        }

        /**
         * Generate format to content
         *
         * @param string $file
         *
         * @return array
         */
        private function setFormatContent(string $file): array {

            $list = [];
            $content = trim(file_get_contents($file));
            $rows = explode("\n", $content);

            if(empty($content) == false):
                if(is_array($rows) AND count($rows) > 0):
                    foreach ($rows AS $value) {
                        $list[] = array_map(function($data) {
                            return trim($data);
                        }, explode('_', $value));
                    }
                    unset($content, $rows, $value);
                endif;
            endif;

            return $list;
        }
    }