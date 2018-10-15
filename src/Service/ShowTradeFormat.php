<?php

    namespace App\Service;

    use Symfony\Component\Filesystem\Filesystem;

    /**
     * Class ShowTradeFormat
     *
     * @package App\Service
     */
    class ShowTradeFormat {

        /**
         * @var array
         */
        private $params;

        /**
         * @var Filesystem
         */
        private $filesystem;

        /**
         * @var ReadFileService
         */
        private $readFile;

        /**
         * ShowTradeFormat constructor.
         *
         * @param Filesystem $filesystem
         * @param FormatPathService $path
         * @param ReadFileService $readFile
         * @throws \Psr\Cache\InvalidArgumentException
         */
        function __construct(Filesystem $filesystem, FormatPathService $path, ReadFileService $readFile) {

            $this->filesystem = $filesystem;
            $this->params = new BagData($path->get());
            $this->readFile = $readFile;
        }

        /**
         * Get data read file trade
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return array|null
         */
        public function get(string $directory, string $campaign, string $file) {

            if($this->params->has($directory)):
                return $this->getInstanceDirectory($directory, $campaign, $file);
            endif;

            return null;
        }

        /**
         * Get instance directory
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return array|null
         */
        private function getInstanceDirectory(string $directory, string $campaign, string $file) {

            if($this->params->getInstance($directory)->getContent() instanceof BagData):
                return $this->getCampaign($campaign, $this->params->getInstance($directory)->getContent(), $file);
            endif;

            return null;
        }

        /**
         * Validate exist campaign
         *
         * @param string $campaign
         * @param BagData $bagData
         *
         * @return array|null
         */
        private function getCampaign(string $campaign, BagData $bagData, string $file) {

            if($bagData->has($campaign)):
                return $this->getInstanceCampaign($campaign, $bagData, $file);
            endif;

            return null;
        }

        /**
         * Get instance campaign
         *
         * @param string $campaign
         * @param BagData $bagData
         *
         * @return array|null
         */
        private function getInstanceCampaign(string $campaign, BagData $bagData, string $file) {

            if($bagData->getInstance($campaign)->getContent() instanceof BagData):
                return $this->getFile($bagData->getInstance($campaign)->getContent(), $file);
            endif;

            return null;
        }

        /**
         * Validate exist trade option
         *
         * @param BagData $bagData
         *
         * @return array|null
         */
        private function getFile(BagData $bagData, string $file) {

            if($bagData->has('Trade')):
                foreach ($bagData->get('Trade') AS $key => $value):
                    if($value['fileName'] === $file):
                        return $this->fileExist($bagData->getInstance('Trade')->getInstance($key));
                    endif;
                endforeach;
            endif;

            return null;
        }

        /**
         * Validate exist file and return data
         *
         * @param BagData $bagData
         *
         * @return array|null
         */
        private function fileExist(BagData $bagData) {

            if($this->filesystem->exists($bagData->getPath())):
                return $this->readFile->getAccountTrade($bagData->getPath());
            endif;

            return null;
        }
    }