<?php

    namespace App\Controller;

    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    /**
     * Class ApiController
     *
     * @Route(path="/api")
     * @package App\Controller
     */
    class ApiController extends Controller {


        /**
         * @Route(path="/public/test")
         */
        public function test() {


            dump($this->container->get('app.api.read.log')->getArray());
            die;
        }

        /**
         * Return public dashboard data
         *
         * @Route(path="/public/dashboard", name="api_public_dashboard", methods={"GET"})
         *
         * @return JsonResponse
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getLoginDashboard(): JsonResponse {

            $path = $this->container->get('app.api.params')->get('directory');

            if($this->container->get('filesystem')->exists($path) != true):
                return new JsonResponse(['code' => 404, 'message' => 'Dashboard no available'], 404);
            endif;

            return new JsonResponse($this->container->get('app.api.show')->getPublicDashboard());
        }

        /**
         * Return menu data
         *
         * @Route(path="/secure/menu", name="api_secure_menu", methods={"GET"})
         *
         * @return JsonResponse
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getMenu(): JsonResponse {

            $path = $this->container->get('app.api.params')->get('directory');

            if($this->container->get('filesystem')->exists($path) != true):
                return new JsonResponse(['code' => 404, 'message' => 'Menu no available'], 404);
            endif;

            return new JsonResponse($this->container->get('app.api.format.menu')->get());
        }

        /**
         * Return general dashboard data
         *
         * @Route(path="/secure/dashboard", name="api_secure_dashboard", methods={"GET"})
         *
         * @return JsonResponse
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getDashboard(): JsonResponse {

            $path = $this->container->get('app.api.params')->get('directory');

            if($this->container->get('filesystem')->exists($path) != true):
                return new JsonResponse(['code' => 404, 'message' => 'Dashboard no available'], 404);
            endif;

            return new JsonResponse($this->container->get('app.api.show')->getDashboard());
        }

        /**
         * Return dashboard account data
         *
         * @Route(
         *     path="/secure/{directory}/dashboard",
         *     name="api_secure_account_dashboard",
         *     requirements={"directory" = "\w+"},
         *     methods={"GET"}
         * )
         *
         * @param string $directory
         *
         * @return JsonResponse
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getAccountDashboard(string $directory): JsonResponse {

            $path = sprintf('%s/%s', $this->container->get('app.api.params')->get('directory'), $directory);

            if($this->container->get('filesystem')->exists($path) != true):
                return new JsonResponse(['code' => 404, 'message' => 'Account no available'], 404);
            endif;

            return new JsonResponse($this->container->get('app.api.show')->getAccountDashboard($directory));
        }

        /**
         * Get information campaign account
         *
         * @Route(
         *     path="/secure/{directory}/{campaign}/information",
         *     name="api_secure_account_campaign",
         *     requirements={"directory" = "\w+", "campaign" = "\w+"},
         *     methods={"GET"}
         * )
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return JsonResponse
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getAccountCampaign(string $directory, string $campaign): JsonResponse {

            $path = sprintf('%s/%s/%s', $this->container->get('app.api.params')->get('directory'), $directory, $campaign);

            if($this->container->get('filesystem')->exists($path) != true):
                return new JsonResponse(['code' => 404, 'message' => 'Account campaign no available'], 404);
            endif;

            return new JsonResponse($this->container->get('app.api.show')->getCampaign($directory, $campaign));
        }

        /**
         * Get information trades
         *
         * @Route(
         *     path="/secure/{directory}/{campaign}/trade",
         *     name="api_secure_account_trade",
         *     requirements={"directory" = "\w+", "campaign" = "\w+"},
         *     methods={"GET"}
         * )
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return JsonResponse
         * @throws \Psr\Cache\InvalidArgumentException
         */
        public function getAccountTrade(string $directory, string $campaign): JsonResponse {

            $path = sprintf('%s/%s/%s', $this->container->get('app.api.params')->get('directory'), $directory, $campaign);

            if($this->container->get('filesystem')->exists($path) != true):
                return new JsonResponse(['code' => 404, 'message' => 'Account trades no available'], 404);
            endif;

            return new JsonResponse($this->container->get('app.api.show')->getTrade($directory, $campaign));
        }
    }