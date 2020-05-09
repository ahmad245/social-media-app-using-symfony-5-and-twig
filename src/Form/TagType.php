<?php

namespace App\Form;

use App\Entity\Tag;
use App\Form\DataTransformer\TagTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TagType extends AbstractType
{
    private $tagTransformer;
    public function __construct(TagTransformer $tagTransformer)
    {
        $this->tagTransformer=$tagTransformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
        ->addModelTransformer(new CollectionToArrayTransformer(),true)
        ->addModelTransformer($this->tagTransformer,true)
          
        ;
    }

    public function getParent()
    {
        return HiddenType::class;
    }
    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Tag::class,
    //     ]);
    // }
}
