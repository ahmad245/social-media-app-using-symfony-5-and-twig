<?php 
namespace App\Form\DataTransformer;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class TagTransformer implements DataTransformerInterface{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    public function transform($value){
       
     
        return implode(',',$value);
    
       
    }
    public function reverseTransform($value){
         
        $names= explode(',',$value);
        $tags=[];
        foreach($names as $name){
            $tag=new Tag();
            $tag->setName($name);
            $tags[]=$tag;
        }
      
        
      return $tags;
    }
}