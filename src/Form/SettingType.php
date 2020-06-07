<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Cities;
use App\Entity\Country;
use App\Entity\Regions;
use App\Entity\Departments;
use App\Repository\CitiesRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use App\Repository\DepartmentsRepository;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SettingType extends AbstractType
{
    private $repoDep;
    private $repoCities;
    public function __construct(DepartmentsRepository $repoDep = null,CitiesRepository $repoCities) {
        $this->repoDep = $repoDep;
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
             'label'=>false
             
         
            // 'asset_helper' => true,
        ])
        ->add('country',EntityType::class, [
            'class' => Country::class,
           // 'choice_label' => 'Country',
            'choice_value' => function (?Country $entity) {
                return $entity ? $entity->getCountryCode() : '';
            },
            
        ])
        
        ->add('phone', TextType::class, [

            'label' => false

        ])
        ->add('birthday', TextType::class, [

            'attr' => [
                'class' => 'datepicker'
            ],
            'required' => false,
            'empty_data' => null,
            
        ])
      //  ->add('picture', TextType::class)
        // ->add('password', PasswordType::class)
        // ->add('confirmPassword', PasswordType::class)
        ->add('introduction', TextareaType::class)
        ->add('bio', TextareaType::class)
        ->add('region', EntityType::class, [
            'class' => Regions::class,
            'mapped' => false,
            'required'   => false,
            
        ]);

        $builder->get('region')->addEventListener(
          FormEvents::POST_SUBMIT,
          function (FormEvent $event) {
            $form = $event->getForm();
           
            $this->addDepartementField($form->getParent(), $form->getData());
          }
        
        
      );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA ,
            function (FormEvent $event) {
              // dd($event->getData());die;
              $data = $event->getData();
              /* @var $ville Ville */
              $city = $data->getCity();
              $form = $event->getForm();
              if ($city) {
              
                // On récupère le département et la région
                $departement = $city->getDepartment();
                $region = $departement->getRegion();
                // On crée les 2 champs supplémentaires
                $this->addDepartementField($form, $region);
                $this->addVilleField($form, $departement);
                // On set les données
                $form->get('region')->setData($region);
                $form->get('department')->setData($departement);
              } 
              else {
                // On crée les 2 champs en les laissant vide (champs utilisé pour le JavaScript)
                $this->addDepartementField($form, null);
                $this->addVilleField($form, null);
              }
            }
          );
     
         
   
}
private function addDepartementField( $form, ?Regions $region)
{
  $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
    'department',
    EntityType::class,
    null,
    [
      'class'           => Departments::class,
      'placeholder'     => $region ? 'Sélectionnez votre département' : 'Sélectionnez votre région',
      'mapped'          => false,
      'required'        => false,
      'auto_initialize' => false,
       'attr'=>['disabled' => 'disabled'],
      'choices'         => $region ? $region->getDepartments() : []
    ]
  );
  
  $builder->addEventListener(
    FormEvents::POST_SUBMIT,
    function (FormEvent $event) {
      $form = $event->getForm();
     
      $this->addVilleField($form->getParent(), $form->getData());
    }
  );
  $form->add($builder->getForm());
 
}
private function addVilleField( $form, ?Departments $departement)
{
  


  $form->add('city', EntityType::class, [
    'class'       => Cities::class,
    'required'        => true,
    'placeholder' => $departement ? 'Sélectionnez votre ville' : 'Sélectionnez votre département',
    'attr'=>['disabled' => 'disabled'],
    'choices'     => $departement ? $departement->getCities() : []
  ]);


}


public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => User::class,
    ]);
}
}