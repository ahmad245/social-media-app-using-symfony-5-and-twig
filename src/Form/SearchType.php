<?php

namespace App\Form;

use App\Entity\Search;
use App\Entity\Country;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identity',TextType::class,[
                'attr' => [
                    'class' => 'autocomplete'
                ],
                'required' => false,
            ])
            ->add('country',EntityType::class, [
                'class' => Country::class,
                'required'   => false,
            ])
           
            ->add('phone',TextType::class, [
                // 'attr' => [
                //     'placeholder' => 'phone'
                // ],
               
                'required' => false,

            ])
            ->add('maxPosts',CheckboxType::class,[
                'required' => false,
            ])
            ->add('maxLikes',CheckboxType::class,[
                'required' => false,
            ])
            ->add('submit',SubmitType::class)
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Search::class,
            'method'=>'GET',
            'csrf_protection'=>false
        ]);
    }
    public function getBlockPrefix()
    {
        return  '';
    }

}
