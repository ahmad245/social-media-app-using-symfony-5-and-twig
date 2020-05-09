<?php
namespace App\Twig;

use App\Entity\CommentNotification;
use App\Entity\FollowingNotification;
use App\Entity\LikeNotification;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtentions extends AbstractExtension implements GlobalsInterface
{
    private $message;
    public function __construct(string $message)
    {
        $this->message=$message;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('price',[$this,'priceFilter']),
        
            new TwigFilter('str',[$this,'strFilter']),
        ];
    }
    public function strFilter($content, $length){
          
        return substr($content,0,$length);
    }

    public function priceFilter($number){
        return '$'.number_format($number,2,'.',',');
    }
    public function getGlobals(): array
    {
        return [
            'locale'=>'fr',
            'message'=>$this->message
        ];
    }
    public function getTests()
    {
        return [
            new \Twig\TwigTest('like',function($obj){
              return $obj instanceof LikeNotification;
            }),
            new \Twig\TwigTest('follow',function($obj){
                return $obj instanceof FollowingNotification;
              }),
              new \Twig\TwigTest('comment',function($obj){
                return $obj instanceof CommentNotification;
              })


        ];
    }
}