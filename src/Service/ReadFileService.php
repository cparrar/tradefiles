<?php

    namespace App\Service;


    /**
     * Class ReadFileService
     *
     * @package App\Service
     */
    class ReadFileService {

        /**
         * @var FormatReadFileService
         */
        private $readFile;

        /**
         * ReadFileService constructor.
         *
         * @param FormatReadFileService $readFile
         */
        function __construct(FormatReadFileService $readFile) {

            $this->readFile = $readFile;
        }

        /**
         * Get information dashboard account
         *
         * @param string $path
         *
         * @return array
         */
        public function getAccountDashboard(string $path) {

            $read = $this->readFile->readFile($path);
            $headers = $read->getHeaders();
            $content = $read->slice(0, 1);

            if(count($headers) > 0 AND count($content) > 0):
                return [$headers[0] => $content[0][0], $headers[2] => $content[0][2], $headers[3] => $content[0][3]];
            endif;

            return [];
        }

        /**
         * Get information campaign account
         *
         * @param string $path
         *
         * @return array
         */
        public function getAccountInformation(string $path) {

            $read = $this->readFile->readFile($path);
            $headers = $read->getHeaders();
            $data = $read->slice(0, 1);

            if(count($headers) > 0 AND count($data) > 0):
                return array_combine($headers, $data[0]);
            endif;

            return [];
        }

        /**
         * Get information campaign account
         *
         * @param string $path
         *
         * @return array
         */
        public function getAccountFileInformation(string $path) {

            $read = $this->readFile->readFile($path);
            $headers = $read->getHeaders();
            $data = $read->slice(0, 4);

            if(count($headers) > 0 AND count($data) > 0):
                return ['headers' => $headers, 'data' => $data];
            endif;

            return [];
        }

        /**
         * Get data read file trade
         *
         * @param string $path
         *
         * @return array
         */
        public function getAccountTrade(string $path) {

            $read = $this->readFile->readFile($path);
            return ['headers' => $read->getHeaders(), 'data' => $read->getData()];
        }
    }