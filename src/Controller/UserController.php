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
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


class UserController extends AbstractFOSRestController {

    /**
     * @SWG\Get(
     *      description="Show one user.",
     *      tags = {"Users"},
     *      @SWG\Response(
     *          response=200,
     *          @Model(type=User::class),
     *          description="Successful operation",
     *      ), 
     *      @SWG\Response(
     *         response="400",
     *         description="Bad Request: Method Not Allowed",
     *      ),
     *      @SWG\Response(
     *         response="401",
     *         description="Unauthorized: Expired JWT Token/JWT Token not found",
     *      ),
     *      @SWG\Response(
     *         response="404",
     *         description="User object not found: Invalid ID supplied/Invalid Route",
     *      )
     * )
     *  
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
    * @SWG\Get(
     *     description="Get the list of users.",
     *     tags = {"Users"},
     *     @SWG\Response(
     *          response=200,
     *          @Model(type=User::class),
     *          description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Bad Request: Method Not Allowed",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: Expired JWT Token/JWT Token not found",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not Found: Invalid Route",
     *     )
     * )
     * 
     * @Route(path="/users", name="userIndex", methods={"GET"})
     * @QueryParam(name="page", default="1")
     * @View
     */
    
     public function list(UserRepository $userRepository, $paramFetcher)
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
     * @SWG\Post(
     *     description="Create user",
     *     tags = {"Users"},
     *     @SWG\Response(
     *          response=201,
     *          @Model(type=User::class),
     *          description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Bad Request: Method Not Allowed",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: Expired JWT Token/JWT Token not found",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not Found: Invalid Route",
     *     ),
     *     @SWG\Parameter(
     *         name="User",
     *         in="body",
     *         @Model(type=User::class)
     *     )
     * )
     * 
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
     * @SWG\Delete(
     *     description="Delete user",
     *     tags = {"Users"},
     *     @SWG\Response(
     *          response=204,
     *          description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Bad Request: Method Not Allowed",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: Expired JWT Token/JWT Token not found",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User object not found: Invalid ID supplied/Invalid Route",
     *     )
     * )
     * 
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
