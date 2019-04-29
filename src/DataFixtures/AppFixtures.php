<?php

namespace App\DataFixtures;

use App\Entity\Phone;
use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Constructor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
        {
  
                $category = new Category();
                $category->setName("Smartphone");
                $manager->persist($category);

                $constructor = new Constructor();
                $constructor->setName("Samsung")
                            ->setCreatedAt(new \DateTimeImmutable());
                $manager->persist($constructor);

                for($i=1; $i <= 4; $i++) {                
                    $image = new Image();
                    $image->setName("Image$i.jpg");
                    $manager->persist($image);
                    
                    $phone = new Phone();

                    $phone  -> setTitle("Smartphone " .$i)
                            -> setContent("Description du téléphone " .$i)
                            -> setConstructor($constructor)
                            -> setCategorie($category)
                            -> setImage($image) 
                            -> setCreatedAt(new \DateTimeImmutable())
                            -> setPrice("200"); 
        
                    $manager->persist($phone);
                }

                    
                $constructor = new Constructor();
                $constructor->setName("Nokia")
                            ->setCreatedAt(new \DateTimeImmutable());
                $manager->persist($constructor);

                for($i=5; $i <= 8; $i++) {                
                    $image = new Image();
                    $image->setName("Image$i.jpg");
                    $manager->persist($image);
                    
                    $phone = new Phone();

                    $phone  -> setTitle("Smartphone " .$i)
                            -> setContent("Description du téléphone " .$i)
                            -> setConstructor($constructor)
                            -> setCategorie($category)
                            -> setImage($image)
                            -> setCreatedAt(new \DateTimeImmutable())
                            -> setPrice("250"); 
        
                    $manager->persist($phone);
                }
                
                $constructor = new Constructor();
                $constructor->setName("Apple")
                            ->setCreatedAt(new \DateTimeImmutable());
                $manager->persist($constructor);

                for($i=9; $i <= 12; $i++) {                
                    $image = new Image();
                    $image->setName("Image$i.jpg");
                    $manager->persist($image);
                    
                    $phone = new Phone();

                    $phone  -> setTitle("Smartphone " .$i)
                            -> setContent("Description du téléphone " .$i)
                            -> setConstructor($constructor)
                            -> setCategorie($category)
                            -> setImage($image)
                            -> setCreatedAt(new \DateTimeImmutable())
                            -> setPrice("300"); 
        
                    $manager->persist($phone);
                }

            $manager->flush();
        }    
}
