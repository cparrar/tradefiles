<?php

    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    /**
     * Class ShowController
     *
     * @Route(path="/show")
     * @package App\Controller
     */
    class ShowController extends Controller {

        
        /**
         * Show dashboard account
         *
         * @Route(
         *     path="/{directory}/dashboard",
         *     name="admin_show_dashboard",
         *     requirements={"directory" = "\w+"},
         *     methods={"GET"}
         * )
         *
         * @param string $directory
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function getDashboard(string $directory): Response {

            $path = sprintf('%s/%s', $this->container->get('app.api.params')->get('directory'), $directory);

            if($this->container->get('filesystem')->exists($path) != true):
                throw $this->createNotFoundException('Account no available');
            endif;

            return $this->render('show/get_dashboard.html.twig', [
                'directory' => $directory,
                'directory_format' => str_replace('_', ' ', $directory)
            ]);
        }

        /**
         * Show campaign account
         *
         * @Route(
         *     path="/{directory}/{campaign}/information",
         *     name="admin_show_campaign",
         *     requirements={"directory" = "\w+", "campaign" = "\w+"},
         *     methods={"GET"}
         * )
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function getCampaign(string $directory, string $campaign): Response {

            $path = sprintf('%s/%s/%s', $this->container->get('app.api.params')->get('directory'), $directory, $campaign);

            if($this->container->get('filesystem')->exists($path) != true):
                throw $this->createNotFoundException('Account Campaign no available');
            endif;

            return $this->render('show/get_campaign.html.twig', [
                'directory' => $directory,
                'directory_format' => str_replace('_', ' ', $directory),
                'campaign' => $campaign,
                'campaign_format' => str_replace('_', ' ', $campaign)
            ]);
        }

        /**
         * Show campaign account
         *
         * @Route(
         *     path="/{directory}/{campaign}/trade",
         *     name="admin_show_trade",
         *     requirements={"directory" = "\w+", "campaign" = "\w+"},
         *     methods={"GET"}
         * )
         *
         * @param string $directory
         * @param string $campaign
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function getTrade(string $directory, string $campaign): Response {

            $path = sprintf('%s/%s/%s', $this->container->get('app.api.params')->get('directory'), $directory, $campaign);

            if($this->container->get('filesystem')->exists($path) != true):
                throw $this->createNotFoundException('Account Campaign Trade no available');
            endif;

            return $this->render('show/get_trade.html.twig', [
                'directory' => $directory,
                'directory_format' => str_replace('_', ' ', $directory),
                'campaign' => $campaign,
                'campaign_format' => str_replace('_', ' ', $campaign)
            ]);
        }
    }