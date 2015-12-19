<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestBookMessageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', [
                'label' => 'Message*',
            ])
            ->add('username', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
                'label' => 'Name*',
            ])
            ->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', [
                'required' => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\GuestBookMessage',
        ]);
    }
}
