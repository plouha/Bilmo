<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcher;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Hateoas\Configuration\Route as HatoasRoute;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractFOSRestController {

    /**
     * @Route(path="users/{id}", name="user_Show", methods={"GET"})
     * @View
     * @param User $user
     * @return user
     */

    public function user_Show(User $user): User
    {

        return $user;

    }
    
    /**
     * @Route(path="users", name="user_Index", methods={"GET"})
     * @QueryParam(name="page", default="1")
     * @View
     */
    
     public function list(UserRepository $userRepository, $paramFetcher)
    {

        $pagerfantaFactory   = new PagerfantaFactory(); 
            
        $pager = $userRepository->getPaginatedUsers($paramFetcher->get("page", 1));
        
        $paginatedCollection = $pagerfantaFactory->createRepresentation(
              $pager,
              new HatoasRoute('user_Index', array())
          );
          
        return $paginatedCollection;

    }

    /**
     * @Route(path="users/", name="user_Add", methods={"POST"})
     * @View
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return user
     */

    public function user_Add(User $user, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): User
    {
        $user = new User();

        $hash = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($hash);
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;

    }
      
    /**
     * @Route(path="users/{id}", name="user_Delete", methods={"DELETE"})
     * @View
     * @param User $user
     * @param EntityManagerInterface $entityManager
     */

    public function user_Delete(User $user, EntityManagerInterface $entityManager)
    {        

        $entityManager->remove($user);
        $entityManager->flush();

    }

}
