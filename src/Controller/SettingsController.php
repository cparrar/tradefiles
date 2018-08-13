<?php

    namespace App\Controller;

    use App\Entity\Parameters;
    use App\Form\SettingEditType;
    use Symfony\Component\Form\FormError;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    /**
     * Class SettingsController
     *
     * @Route(path="/settings")
     * @package App\Controller
     */
    class SettingsController extends Controller {

        /**
         * @Route(path="/", name="admin_settings_list", methods={"GET"})
         */
        public function getList(): Response {

            return $this->render('settings/get_list.html.twig', ['array' => $this->getQueryList()]);
        }

        /**
         * Edit data
         *
         * @Route(path="/{id}/edit", name="admin_settings_edit", requirements={"id" = "\d+"}, methods={"GET", "POST"})
         *
         * @param Parameters $parameters
         * @param Request $request
         *
         * @return Response
         */
        public function getEdit(Parameters $parameters, Request $request): Response {

            $form = $this->getEditForm($parameters);
            $form->handleRequest($request);

            if($form->isSubmitted() AND $form->isValid()):


                if(in_array($parameters->getId(), [1, 2])):
                    $filesystem = $this->container->get('filesystem');

                    if($filesystem->exists($form->get('value')->getData()) != true):
                        $form->get('value')->addError(new FormError('directory does not exist.'));
                    endif;
                endif;

                if($form->isValid()):
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();

                    return $this->redirectToRoute('admin_settings_list');
                endif;
            endif;

            return $this->render('settings/get_edit.html.twig', ['form' => $form->createView(), 'entity' => $parameters]);
        }

        /**
         * Generate form
         *
         * @param Parameters $parameters
         *
         * @return \Symfony\Component\Form\FormInterface
         */
        private function getEditForm(Parameters $parameters) {

            return $this->createForm(SettingEditType::class, $parameters, [
                'action' => $this->generateUrl('admin_settings_edit', ['id' => $parameters->getId()]),
                'method' => 'POST'
            ]);
        }

        /**
         * Get Query params configuration
         *
         * @param array $list
         *
         * @return array
         */
        private function getQueryList(array $list = []): array {

            $em = $this->getDoctrine();
            $types = $em->getRepository('App:TypeParameters')->findBy(['is_active' => true], ['id' => 'ASC']);

            foreach ($types AS $type):
                $array = $em->getRepository('App:Parameters')->findBy(['type' => $type], ['title' => 'ASC']);
                if(count($array) > 0):
                    $list[$type->getName()] =  $array;
                endif;
            endforeach;

            return $list;
        }
    }
