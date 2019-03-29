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
     * @View
     */

    public function user_Index()
    {

        $user = $this->getDoctrine()->getRepository('App:User')->findAll();

        return $user;

    }

    /**
     * @Route(path="/", name="user_Add", methods={"POST"})
     * @View
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return user
     */

    public function user_Add(User $user, EntityManagerInterface $entityManager): User
    {
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
