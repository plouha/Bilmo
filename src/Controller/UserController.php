<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcher;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Hateoas\Configuration\Route as HatoasRoute;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class UserController extends AbstractFOSRestController {

    /**
     * @Route(path="/users/{id}", name="userShow", methods={"GET"})
     * @View
     * @IsGranted("view", subject="user")
     * @param User $user
     * @return user
     */

    public function userShow(User $user): User
    {

        return $user;

    }
    
    /**
     * @Route(path="/users", name="userIndex", methods={"GET"})
     * @QueryParam(name="page", default="1")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @View
     */
    
     public function list(User $user, UserRepository $userRepository, $paramFetcher)
    { 

        $pagerfantaFactory   = new PagerfantaFactory();
         
        $pager = $userRepository->getPaginatedUsers($paramFetcher->get("page", 1), $this->getUser()); 
            
        $paginatedCollection = $pagerfantaFactory->createRepresentation(
              $pager,
              new HatoasRoute('userIndex', array())
          );
          
        return $paginatedCollection;

    }

    /**
     * @Route(path="/users", name="userAdd", methods={"POST"})
     * @View
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return user
     */

    public function userAdd(User $user, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): User
    {
        $user->setClient($this->getUser());
        $hash = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($hash);
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;

    }
      
    /**
     * @Route(path="/users/{id}", name="userDelete", methods={"DELETE"})
     * @View
     * @IsGranted("delete", subject="user")
     * @param User $user
     * @param EntityManagerInterface $entityManager
     */

    public function userDelete(User $user, EntityManagerInterface $entityManager)
    {        

        $entityManager->remove($user);
        $entityManager->flush();

    }

}
