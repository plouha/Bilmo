<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;


class ClientFixtures extends Fixture 
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
        {
          $this->encoder = $encoder;
        }

    public function load(ObjectManager $manager)
        {
            
                $client = new Client();
                $client->setEmail("client1@gmail.com");
                $client->setName("Client1");
                $password = $this->encoder->encodePassword($client, 'password');
                $client->setPassword($password);

                $manager->persist($client);

                for($i=1; $i <= 4; $i++) {                
                    $user = new User();
                    $user->setEmail("user".$i."@gmail.com");
                    $user->setUsername("User" .$i);
                    $password = $this->encoder->encodePassword($user, 'password');
                    $user->setPassword($password);
                    $user->setClient($client);
                    
                    $manager->persist($user);

                }

                $client = new Client();
                $client->setEmail("client2@gmail.com");
                $client->setName("Client2");
                $password = $this->encoder->encodePassword($client, 'password');
                $client->setPassword($password);

                $manager->persist($client);

                for($i=5; $i <= 8; $i++) {                
                    $user = new User();
                    $user->setEmail("user".$i."@gmail.com");
                    $user->setUsername("User" .$i);
                    $password = $this->encoder->encodePassword($user, 'password');
                    $user->setPassword($password);
                    $user->setClient($client);
                    
                    $manager->persist($user);

                }

                $client = new Client();
                $client->setEmail("client3@gmail.com");
                $client->setName("Client3");
                $password = $this->encoder->encodePassword($client, 'password');
                $client->setPassword($password);

                $manager->persist($client);

                for($i=9; $i <= 12; $i++) {                
                    $user = new User();
                    $user->setEmail("user".$i."@gmail.com");
                    $user->setUsername("User" .$i);
                    $password = $this->encoder->encodePassword($user, 'password');
                    $user->setPassword($password);
                    $user->setClient($client);
                    
                    $manager->persist($user);

                }
            
            $manager->flush();
        }    
}
