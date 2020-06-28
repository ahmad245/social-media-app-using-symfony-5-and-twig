<?php

namespace App\Form;

use App\Entity\Cities;
use App\Entity\Country;
use App\Entity\Departments;
use App\Entity\Regions;
use App\Entity\User;
use App\Repository\CitiesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AccountType extends AbstractType
{
    private $repoCities;
    public function __construct(CitiesRepository $repoCities)
    {
        $this->repoCities = $repoCities;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('file', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                 'image_uri' => false,
                 'label'=>false,
               
                 
             
                // 'asset_helper' => true,
            ])
            ->add('country',EntityType::class, [
                'class' => Country::class,
               // 'choice_label' => 'Country',
                'choice_value' => function (?Country $entity) {
                    return $entity ? $entity->getCountryCode() : '';
                },
                //'required'   => false,
            ])
            // ->add('address', ChoiceType::class, [
            //     'mapped' => false,
            //     'required'   => false,
            //     'attr' => [
            //         'id' => 'address-country'
            //     ]
            // ])
            ->add('phone', TextType::class, [

                'label' => false

            ])
            ->add('birthday', TextType::class, [

                'attr' => [
                    'class' => 'datepicker'
                ],
                'required' => false,
                'empty_data' => null,
                // 'widget' => 'single_text',
                // 'html5' => false,

            ])
          //  ->add('picture', TextType::class)
            ->add('password', PasswordType::class)
            ->add('confirmPassword', PasswordType::class)
            ->add('introduction', TextareaType::class)
            ->add('bio', TextareaType::class)
            ->add('region', EntityType::class, [
                'class' => Regions::class,
                'mapped' => false,
                'required'   => false,
            ])
            ->add('department', ChoiceType::class, [
                'mapped' => false,
                'required'   => false,


            ])
            ->add('city', EntityType::class, [
                'class' => Cities::class,
                'required'   => false,
                // 'mapped' => false,
                // 'required'   => false,
                'choices' => []
            ]);
        //$builder->get('address')->resetViewTransformers();
        $builder->get('department')->resetViewTransformers();
        $builder->get('city')->resetViewTransformers();

        $builder->get('city')->addEventListener(
            FormEvents::PRE_SUBMIT ,
            function (FormEvent $event) {
                $event->setData($this->getDataFromRepository((int)$event->getData() ));
              
            }
        );
    
       
    }

    private function getDataFromRepository($id)
    {
        if($id==null) return;
        $result =  $this->repoCities->findOneBy(['id' => $id]);
        return $result;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
