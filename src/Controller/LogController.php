<?php

    namespace App\Controller;

    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    /**
     * Class LogController
     *
     * @Route(path="/logs")
     * @package App\Controller
     */
    class LogController extends Controller {

        /**
         * @Route("/", name="admin_logs_format")
         */
        public function index() {

            return $this->render('log/index.html.twig', [
                'controller_name' => 'LogController',
            ]);
        }
    }
