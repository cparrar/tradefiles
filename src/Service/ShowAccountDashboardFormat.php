<?php

    namespace App\Service;

    use Symfony\Component\Filesystem\Filesystem;

    /**
     * Class ShowAccountDashboardFormat
     *
     * @package App\Service
     */
    class ShowAccountDashboardFormat {

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
         * ShowCampaignFormat constructor.
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
         *
         * @return array|null
         */
        public function get(string $directory) {

            if($this->params->has($directory)):
                return $this->getInstanceDirectory($directory);
            endif;

            return null;
        }

        /**
         * Get instance directory
         *
         * @param string $directory
         *
         * @return array|null
         */
        private function getInstanceDirectory(string $directory) {

            if($this->params->getInstance($directory)->getContent() instanceof BagData):
                return $this->getFile($this->params->getInstance($directory)->getContent());
            endif;

            return null;
        }

        /**
         * Validate exist
         *
         * @param BagData $bagData
         *
         * @return array|null
         */
        private function getFile(BagData $bagData) {

            if($bagData->has('Dashboard')):
                return $this->fileExist($bagData->getInstance('Dashboard'));
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
                return $this->readFile->getAccountDashboard($bagData->getPath());
            endif;

            return null;
        }
    }