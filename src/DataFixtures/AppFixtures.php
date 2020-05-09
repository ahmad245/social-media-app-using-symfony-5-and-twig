<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Migrations\Version\Factory as VersionFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\Traits\FactoryTrait;

class AppFixtures extends Fixture
{
    private $faker;
    private $manager;
    private $users = [];
    private $rolesArr = [];
    protected $encode;

    public function __construct(UserPasswordEncoderInterface $encode)
    {
        $this->encode = $encode;
    }
    public function load(ObjectManager $manager)
    {

        $this->manager = $manager;
        $this->faker = Factory::create('FR-fr');
        $this->roles();
        $this->user();
        $this->post();
    }
    public function roles()
    {
        $roles = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPERADMIN', 'ROLE_WRITER', 'ROLE_EDITER'];
        for ($i = 0; $i <= 4; $i++) {

            $role = new Role();
            $role->setName($roles[$i]);
            $this->rolesArr[] = $role;
            $this->manager->persist($role);
        }
        $this->manager->flush();
    }
    public function user()
    {

        for ($i = 0; $i <= 10; $i++) {
            $user = new User();

            $user->setFirstName($this->faker->firstname);
            $user->setLastName($this->faker->lastname);
            $user->setEmail($this->faker->email);
            $user->setIntroduction($this->faker->sentence());
            $user->setBio($this->faker->realText(rand(10, 400)));
            $user->setPicture($this->faker->imageUrl(1000, 350));

            $hash = $this->encode->encodePassword($user, 'Syria245!');

            $user->setPassword($hash);
            $user->setEnabled(true);

            $user->addUserRole($this->rolesArr[rand(0, 4)]);
            $this->manager->persist($user);

            $this->users[] = $user;
        }
        $this->manager->flush();
    }

    public function post(){
        for ($i=0; $i < 100; $i++) { 
          $post=new Post();
          $post->setContent($this->faker->realText(rand(10, 2000)));

          $post->setUser($this->users[rand(0,count($this->users)-1)]);

          $this->manager->persist($post);
        }
        $this->manager->flush();
    }
}
