<?php
namespace App\Security;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\InvalidConfirmationTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserConfirmationService{
    private $userRepo;
    private $em;
    private $encode;
    public function __construct(UserRepository $userRepo,EntityManagerInterface $em,  UserPasswordEncoderInterface $encode)
    {
        $this->userRepo=$userRepo;
        $this->em=$em;
        $this->encode=$encode;
    }

    public function confirmUser(string $token)
    {
        $user=$this->userRepo->findOneBy(
            ['confirmationToken'=>$token]
        );

        if(!$user)
        {
            throw new InvalidConfirmationTokenException();
        }
        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $this->em->flush();
    }

    public function confirmUserAndPassword(string $token,string $password)
    {
        $user=$this->userRepo->findOneBy(
            ['confirmationToken'=>$token]
        );

        if(!$user)
        {
            throw new InvalidConfirmationTokenException();
        }
        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setPassword($this->encode->encodePassword($user,$password));

        $this->em->flush();
    }
}