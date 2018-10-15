<?php

    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\HiddenType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class CampaignConfigureType extends AbstractType {

        /**
         * Proceso de configuracion del formulario
         * para seleccion de configuracion
         *
         * @param FormBuilderInterface $builder
         * @param array                $options
         */
        public function buildForm(FormBuilderInterface $builder, array $options) {

            $builder->add('Account', HiddenType::class, ['data' => $options['_account']]);
            $builder->add('Symbol', HiddenType::class, ['data' => $options['']]);
            $builder->add('Strategy', HiddenType::class, ['data' => $options['']]);
            $builder->add('BarType', HiddenType::class, ['data' => $options['']]);
            $builder->add('Type', HiddenType::class, ['data' => $options['']]);
            $builder->add('UsingATM', HiddenType::class, ['data' => $options['']]);

        }

        /**
         * Configuraciones
         *
         * @param OptionsResolver $resolver
         */
        public function configureOptions(OptionsResolver $resolver) {

            $resolver->setDefaults([
                '_account' => null,
                '_symbol' => null
            ]);
        }
    }
