<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * Class DashboardController
     *
     * @package App\Controller
     */
    class DashboardController extends Controller {

        /**
         * Show dashboard general
         *
         * @Route("/", name="admin_dashboard", methods={"GET"})
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function getDashboard() {

            return $this->render('dashboard/dashboard.html.twig');
        }
    }