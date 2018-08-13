<?php

    namespace App\Form;

    use App\Entity\Parameters;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Validator\Constraints\NotBlank;

    /**
     * Class SettingEditType
     *
     * @package App\Form
     */
    class SettingEditType extends AbstractType {

        /**
         * @param FormBuilderInterface $builder
         * @param array $options
         */
        public function buildForm(FormBuilderInterface $builder, array $options) {

            $builder->add('value', TextType::class, [
                'label' => 'Value Data',
                'constraints' => [
                    new NotBlank()
                ]
            ]);
        }

        /**
         * @param OptionsResolver $resolver
         */
        public function configureOptions(OptionsResolver $resolver) {

            $resolver->setDefaults(['data_class' => Parameters::class]);
        }
    }
