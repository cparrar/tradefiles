<?php

    namespace App\Service;


    use Symfony\Bundle\FrameworkBundle\Routing\Router;
    use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

    class FormatMenuService {

        /**
         * @var FormatPathService
         */
        private $path;

        /**
         * @var BagParameterService
         */
        private $parameter;

        /**
         * @var Router
         */
        private $router;

        /**
         * FormatMenuService constructor.
         *
         * @param FormatPathService $path
         * @param BagParameterService $parameter
         * @param Router $router
         */
        public function __construct(FormatPathService $path, BagParameterService $parameter, Router $router) {

            $this->path = $path;
            $this->parameter = $parameter;
            $this->router = $router;
        }

        /**
         * Return menu data
         *
         * @return mixed|\Symfony\Component\Cache\CacheItem
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function get() {

            return $this->getFormat();
        }

        /**
         * Generate format of data
         *
         * @return array
         * @throws \Psr\Cache\InvalidArgumentException
         */
        private function getFormat() {

            $list = [];
            $array = $this->path->get();

            foreach ($array AS $value):
                $content = is_array($value['content']) ? $this->getLevel2($value['directory'], $value['content']) : null;
                if(is_array($content)):
                    $list[] = $this->getDirectoryFormat($value, $content);
                endif;
            endforeach;

            return $list;
        }

        /**
         * Generate data level 3
         *
         * @param string $directory
         * @param array $array
         *
         * @return array|null
         */
        private function getLevel2(string $directory, array $array = []) {

            $list = [];
            foreach ($array AS $value):
                if($value['isFile']):
                    $list[] = $this->getFileFormat($value, 'admin_show_dashboard', ['directory' => $directory]);
                else:
                    $content = is_array($value['content']) ? $this->getLevel3($directory, $value['content']) : null;
                    if(is_array($content)):
                        $list[] = $this->getDirectoryFormat($value, $content);
                    endif;
                endif;
            endforeach;

            return count($list) > 0 ? $list : null;
        }

        /**
         * Generate level 3 data
         *
         * @param string $directory
         * @param array $array
         *
         * @return array|null
         */
        private function getLevel3(string $directory, array $array = []) {

            $list = [];
            foreach ($array AS $key => $value):
                if($value['isFile']):
                    if($key == 'Information'):
                        $list[] = $this->getFileFormat($value, 'admin_show_campaign', ['directory' => $directory, 'campaign' => $value['directory']]);
                    else:
                        $list[] = $this->getFileFormat($value, 'admin_show_trade', ['directory' => $directory, 'campaign' => $value['directory']]);
                    endif;
                endif;
            endforeach;

            return count($list) > 0 ? $list : null;
        }

        /**
         * Generate URL
         *
         * @param string $route
         * @param array $params
         *
         * @return string
         */
        private function getUrl(string $route, array $params = []) {

            return $this->router->generate($route, $params, UrlGeneratorInterface::ABSOLUTE_URL);
        }

        /**
         * Get params for file
         *
         * @param array $array
         * @param string $route
         * @param array $params
         *
         * @return array
         */
        private function getFileFormat(array $array = [], string $route, array $params = []): array {

            $object = new LinkConstruct($array['name'], $array['isFile'], $this->getUrl($route, $params), null);
            return $object->getArray();
        }

        /**
         * Get Params Menu
         *
         * @param array $array
         * @param array $content
         *
         * @return array
         */
        private function getDirectoryFormat(array $array = [], array $content = []): array {

            $object = new LinkConstruct($array['name'], $array['isFile'], null, $content);
            return $object->getArray();
        }
    }