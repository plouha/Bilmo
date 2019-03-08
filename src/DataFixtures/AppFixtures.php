<?php

namespace App\DataFixtures;

use App\Entity\Phone;
use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Constructor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
        {

                for($m = 1; $m <= 12; $m++) {
                    $image = new Image();
                    $image->setName("Image$m.jpg");

                    $manager->persist($image);
                }


                $constructor = new Constructor();
                $constructor->setName("Samsung")
                            ->setCreatedAt(new \DateTime());
                $manager->persist($constructor);
                
                $category = new Category();
                $category->setName("Smartphone");
                $manager->persist($category);

                for($i=1; $i <= 4; $i++) {                
                $phone = new Phone();

                $phone   -> setMarque("Samesung")
                         -> setTitle("Smartphone " .$i)
                         -> setContent("Description du téléphone " .$i)
                         -> setConstructor($constructor)
                         -> setCategorie($category)
                         /*-> setImage($i) */
                         -> setCreatedAt(new \DateTime())
                         -> setPrice("200"); 
        
                $manager->persist($phone);
                }


                $constructor = new Constructor();
                $constructor->setName("Nokia")
                            ->setCreatedAt(new \DateTime());
                $manager->persist($constructor);
                
                $category->setName("Smartphone");

                for($i=5; $i <= 8; $i++) {                
                $phone = new Phone();

                $phone   -> setMarque("Nokia")
                         -> setTitle("Smartphone " .$i)
                         -> setContent("Description du téléphone " .$i)
                         -> setConstructor($constructor)
                         -> setCategorie($category)
                         /*-> setImage($i)*/
                         -> setCreatedAt(new \DateTime())
                         -> setPrice("250"); 
        
                $manager->persist($phone);
                }


                $constructor = new Constructor();
                $constructor->setName("Apple")
                            ->setCreatedAt(new \DateTime());
                $manager->persist($constructor);

                $category->setName("Smartphone");

                for($i=9; $i <= 12; $i++) {                
                $phone = new Phone();

                $phone   -> setMarque("Apple")
                         -> setTitle("Smartphone " .$i)
                         -> setContent("Description du téléphone " .$i)
                         -> setConstructor($constructor)
                         -> setCategorie($category)
                         /*-> setImage($i)*/
                         -> setCreatedAt(new \DateTime())
                         -> setPrice("300"); 
        
                $manager->persist($phone);
                }

            $manager->flush();
        }    
}
