<?php

    namespace App\Controller;

    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    /**
     * Class SecurityController
     *
     * @package App\Controller
     */
    class SecurityController extends Controller {

        /**
         * Show template login
         *
         * @Route(path="/login", name="admin_login", methods={"GET"})
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function getLogin() {

            $util = $this->get('security.authentication_utils');
            return $this->render('template/login.html.twig', ['last_username' => $util->getLastUsername(), 'error' => $util->getLastAuthenticationError()]);
        }

        /**
         * Proccess login user
         *
         * @Route(path="/login_check", name="admin_login_check", methods={"POST"})
         */
        public function getLoginCheck() {

        }

        /**
         * Logout session
         *
         * @Route(path="/logout", name="admin_logout", methods={"GET"})
         */
        public function getLogOut() {

        }
    }