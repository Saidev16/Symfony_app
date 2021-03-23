<?php

namespace AdminBundle\Form;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\src\AdminBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('description')->add('body')->add('slug')->add('datepublish', DateType::class, array(
            'widget'=> 'single_text',
            'format' => 'yyyy-MM-dd',
            'data' => new \DateTime
        ) )
        ->add('categories', EntityType::class, array(
            'class'=> 'AdminBundle:Category',
            'choice_label'=> 'libelle',
            'expanded'=> false,
            'multiple' => true
        ) )
        ->add('image', FileType::class , ['label' => 'image png ou jpeg', 'data_class'=> null ]  );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Post',
            'attr'=>array('novalidate'=>'novalidate')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_post';
    }


}
