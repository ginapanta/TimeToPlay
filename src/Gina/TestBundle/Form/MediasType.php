<?php

namespace Gina\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediasType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
//            ->add('dateAjout')
            ->add('genres')            
            ->add('file','file' ,array(
                                        'label'  => 'Chanson', 
                                        'required' => true,
                                       ))
            ->add('Add', 'submit') 
            ->getForm();
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gina\TestBundle\Entity\Medias'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gina_testbundle_medias';
    }
}
