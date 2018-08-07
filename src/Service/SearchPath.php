<?php

    namespace App\Service;

    use Symfony\Component\Finder\Finder;

    /**
     * Class SearchPath
     *
     * @package App\Service
     */
    class SearchPath {

        /**
         * @var string
         */
        private $pattern;

        /**
         * @var array
         */
        private $params;

        /**
         * SearchPath constructor.
         *
         * @param string $path
         * @param string $pattern
         */
        function __construct(string $path, string $pattern) {

            $this->pattern = $pattern;
            $this->params = [];
            $this->getLevel1($path);
        }

        /**
         * Get array data
         *
         * @return array
         */
        public function getArray(): array {

            return $this->params;
        }

        /**
         * Search leve 1 directories
         *
         * @param string $path
         */
        private function getLevel1(string $path) {

            $directories = $this->searchPathDirectories($path);

            if($directories->count() > 0):
                foreach ($directories AS $directory):

                    $content = $this->getLevel2($directory->getRealPath());
                    if(is_array($content)):
                        $this->params[$directory->getRelativePathname()] = (new ParamsConstruct(
                            $this->getNameFormat($directory->getRelativePathname()),
                            $directory->getRelativePathname(),
                            $directory->getRealPath(),
                            $directory->isDir(),
                            $directory->isFile(),
                            $content
                        ))->getArray();
                    endif;
                endforeach;
            endif;
        }

        /**
         * Get level 2
         *
         * @param string $path
         *
         * @return array
         */
        private function getLevel2(string $path) {

            $list = [];
            $files = $this->searchPathFiles($path, 0);

            if($files->count() > 0):
                foreach ($files AS $file):
                    $list['Dashboard'] = (new ParamsConstruct(
                        'Dashboard',
                        '',
                        $file->getRealPath(),
                        $file->isDir(),
                        $file->isFile()
                    ))->getArray();
                endforeach;
            endif;

            $directories = $this->searchPathDirectories($path);

            if($directories->count() > 0):
                foreach ($directories AS $directory):

                    $content = $this->getLevel3($directory->getRealPath(), $directory->getRelativePathname());
                    if(is_array($content)):
                        $list[$directory->getRelativePathname()] = (new ParamsConstruct(
                            $this->getNameFormat($directory->getRelativePathname()),
                            $directory->getRelativePathname(),
                            $directory->getRealPath(),
                            $directory->isDir(),
                            $directory->isFile(),
                            $content
                        ))->getArray();
                    endif;
                endforeach;
            endif;
            return count($list) > 0 ? $list : null;
        }

        /**
         * Get Level 3
         *
         * @param string $path
         * @param string $directory
         *
         * @return array
         */
        private function getLevel3(string $path, string $directory) {

            $list = [];
            $files = $this->searchPathFiles($path);
            if($files->count() > 0):
                foreach ($files AS $file):
                    $list['Information'] = (new ParamsConstruct('Information',
                        $directory,
                        $file->getRealPath(),
                        $file->isDir(),
                        $file->isFile()
                    ))->getArray();
                endforeach;
            endif;

            $files2 = $this->searchPathFiles($path, 1);
            if($files2->count() > 0):
                foreach ($files2 AS $file):
                    $list['Trade'] = (new ParamsConstruct('Trade',
                        $directory,
                        $file->getRealPath(),
                        $file->isDir(),
                        $file->isFile()
                    ))->getArray();
                endforeach;
            endif;

            return count($list) > 0 ? $list : null;
        }

        /**
         * Search files
         *
         * @param string $path
         * @param int $depth
         *
         * @return null|Finder
         */
        private function searchPathFiles(string $path, int $depth = 0) {

            $finder = new Finder();
            $finder->files()->in($path)->name(sprintf('%s*.csv', $this->pattern))->sortByName()->depth($depth);

            return $finder;
        }

        /**
         * Search directories
         *
         * @param string $path
         * @param int $depth
         *
         * @return null|Finder
         */
        private function searchPathDirectories(string $path, int $depth = 0) {

            $finder = new Finder();
            $finder->directories()->in($path)->depth($depth)->sortByName();

            return $finder;
        }

        /**
         * Get format name
         *
         * @param string $name
         *
         * @return mixed
         */
        private function getNameFormat(string $name) {

            return str_replace('_', ' ', $name);
        }
    }