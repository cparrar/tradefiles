<?php

    namespace App\Service;

    /**
     * Class ShowService
     *
     * @package App\Service
     */
    class ShowService {

        /**
         * @var FormatPathService
         */
        private $path;

        /**
         * @var CacheService
         */
        private $cache;

        /**
         * @var BagParameterService
         */
        private $parameter;

        /**
         * @var ShowAccountDashboardFormat
         */
        private $dashboard;

        /**
         * @var ShowCampaignFormat
         */
        private $campaign;

        /**
         * @var ShowCampaignFileFormat
         */
        private $campaignFile;

        /**
         * @var ShowTradeFormat
         */
        private $tradeFormat;

        /**
         * @var ReadLogService
         */
        private $log;

        /**
         * ShowService constructor.
         *
         * @param FormatPathService $path
         * @param CacheService $cache
         * @param BagParameterService $parameter
         * @param ShowAccountDashboardFormat $dashboard
         * @param ShowCampaignFormat $campaign
         * @param ShowCampaignFileFormat $campaignFile
         * @param ShowTradeFormat $tradeFormat
         * @param ReadLogService $log
         */
        function __construct(FormatPathService $path, CacheService $cache, BagParameterService $parameter, ShowAccountDashboardFormat $dashboard, ShowCampaignFormat $campaign, ShowCampaignFileFormat $campaignFile, ShowTradeFormat $tradeFormat, ReadLogService $log) {

            $this->path = $path;
            $this->cache = $cache;
            $this->parameter = $parameter;
            $this->dashboard = $dashboard;
            $this->campaign = $campaign;
            $this->campaignFile = $campaignFile;
            $this->tradeFormat = $tradeFormat;
            $this->log = $log;
        }

        /**
         * Get data dashboard
         *
         * @return array|mixed|\Symfony\Component\Cache\CacheItem
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getPublicDashboard() {

            if($this->cache->has('cache_dashboard_public')):
                return $this->cache->get('cache_dashboard_public');
            else:
                $data = $this->getDashboardFormat();
                $this->cache->set('cache_dashboard_public', $data, $this->parameter->get('cache_dashboard_public', 20));
                return $data;
            endif;
        }

        /**
         * Get data dashboard
         *
         * @return array|mixed|\Symfony\Component\Cache\CacheItem
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getDashboard() {

            if($this->cache->has('cache_dashboard')):
                return $this->cache->get('cache_dashboard');
            else:
                $data = $this->getDashboardFormat(true);
                $this->cache->set('cache_dashboard', $data, $this->parameter->get('cache_dashboard'));
                return $data;
            endif;
        }

        /**
         * Get data all dashboards
         *
         * @param bool $logs
         *
         * @return array
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getDashboardFormat(bool $logs = false) {

            $list = [];
            $list['logs'] = ($logs == true) ? $this->log->getRawLimited($this->parameter->get('log_raw_show', 10)) : null;
            $array = $this->path->get();

            if(count($array) > 0):
                foreach ($array AS $value):
                    $list['accounts'][] = ['name' => $value['name'], 'content' => $this->dashboard->get($value['directory'])];
                endforeach;
            endif;

            return $list;
        }

        /**
         * Get data dashboard of account
         *
         * @param string $directory
         *
         * @return array|mixed|\Symfony\Component\Cache\CacheItem
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getAccountDashboard(string $directory) {

            if($this->cache->has('cache_dashboard_account')):
                return $this->cache->get('cache_dashboard_account');
            else:
                $data = $this->getAccountFormat($directory);
                $this->cache->set('cache_dashboard_account', $data, $this->parameter->get('cache_dashboard_account'));
                return $data;
            endif;
        }

        /**
         * Get format
         *
         * @param string $directory
         *
         * @return array
         * @throws \Psr\Cache\InvalidArgumentException
         */
        private function getAccountFormat(string $directory) {

            $list = [];
            $array = $this->path->get();

            if(array_key_exists($directory, $array)):
                $list['logs'] = $this->log->getRawLimited($this->parameter->get('log_raw_show', 10));
                $list['account'] = ['name' => $array[$directory]['name'], 'content' => $this->dashboard->get($directory)];
                if(is_array($array[$directory]['content'])):
                    $list['info'] = $this->getAccountFormatInfo($directory, $array[$directory]['content']);
                endif;
            endif;

            return $list;
        }

        /**
         * Get format
         *
         * @param string $directory
         * @param array $array
         *
         * @return array|null
         */
        private function getAccountFormatInfo(string $directory, array $array = []) {

            $list = [];
            foreach ($array AS $key => $value):
                if($value['isDir']):
                    $list[] = ['name' => $value['name'], 'content' => $this->campaign->get($directory, $value['directory'])];
                endif;
            endforeach;

            return count($list) > 0 ? $list : null;
        }

        /**
         * Return data campaign
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return array|mixed|\Symfony\Component\Cache\CacheItem
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getCampaign(string $directory, string $campaign) {

            if($this->cache->has('cache_account_campaign')):
                return $this->cache->get('cache_account_campaign');
            else:
                $data = $this->getCampaignFormat($directory, $campaign);
                $this->cache->set('cache_account_campaign', $data, $this->parameter->get('cache_account_campaign'));
                return $data;
            endif;
        }

        /**
         * Get format
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return array
         * @throws \Psr\Cache\InvalidArgumentException
         */
        private function getCampaignFormat(string $directory, string $campaign) {

            $list = [];
            $array = $this->path->get();

            if(array_key_exists($directory, $array)):
                $list['logs'] = $this->log->getRawLimited($this->parameter->get('log_raw_show', 10));
                $list['account'] = ['name' => $array[$directory]['name'], 'content' => $this->dashboard->get($directory)];
                $list['campaign'] = $this->campaignFile->get($directory, $campaign);
            endif;

            return $list;
        }

        /**
         * Get data of trade file
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return array|mixed|\Symfony\Component\Cache\CacheItem
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getTrade(string $directory, string $campaign) {

            if($this->cache->has('cache_account_trade')):
                return $this->cache->get('cache_account_trade');
            else:
                $data = $this->getTradeFormat($directory, $campaign);
                $this->cache->set('cache_account_trade', $data, $this->parameter->get('cache_account_trade'));
                return $data;
            endif;
        }

        /**
         * Get format
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return array
         * @throws \Psr\Cache\InvalidArgumentException
         */
        private function getTradeFormat(string $directory, string $campaign) {

            $list = [];
            $array = $this->path->get();

            if(array_key_exists($directory, $array)):
                $list['logs'] = $this->log->getRawLimited($this->parameter->get('log_raw_show', 10));
                $list['account'] = ['name' => $array[$directory]['name'], 'content' => $this->dashboard->get($directory)];
                $list['trade'] = $this->tradeFormat->get($directory, $campaign);
            endif;

            return $list;
        }
    }