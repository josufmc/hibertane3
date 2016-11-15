<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EntryType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array('label' => 'Título',
                    'attr' => array('class' => 'form-control')))
                ->add('content', TextareaType::class, array('label' => 'Contenido',
                    'attr' => array('class' => 'form-control')))
                ->add('status', ChoiceType::class, array('label' => 'Estado',
                    'attr' => array('class' => 'form-control'),
                    'choices' => array(
                        'Publicado' => 'public',
                        'Privado' => 'private',
            )))
                ->add('image', FileType::class, array('label' => 'Imagen',
                    'attr' => array('class' => ''), 'data_class' => null))
                ->add('category', EntityType::class, array(
                    'required' => 'required',
                    'label' => 'Categorías',
                    'attr' => array(
                        'class' => 'form-name form-control'
                        ),
                    'class' => 'BlogBundle:Category'
                    )
                )
                ->add('tags', TextType::class, 
                        array(
                            'label' => 'Etiquetas',
                            'attr' => array(
                                'class' => 'form-control'),
                            'mapped' => FALSE   // Quitamos la vinculación con doctryne
                            ))
                ->add('Guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-success')))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Entry'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'blogbundle_entry';
    }

}
