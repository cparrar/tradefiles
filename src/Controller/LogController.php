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
        public function getFormat() {

            return $this->render('log/get_format.html.twig');
        }

        /**
         * @Route(path="/raw", name="admin_logs_raw")
         */
        public function getRaw() {

            return $this->render('log/get_raw.html.twig');
        }
    }