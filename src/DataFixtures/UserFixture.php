<?php

namespace App\DataFixtures;

use App\Entity\Klant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $this->createMany('1','main_users',function($i){
            $klant = new Klant();
            $klant->setEmail(sprintf('robkwanten@hotmail.com', $i))
                ->setPassword($this->passwordEncoder->encodePassword($klant, 'example'))
                ->setRoles([]);

            return $klant;
        });
        $manager->flush();
    }
}
