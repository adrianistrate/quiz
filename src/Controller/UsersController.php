<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\VarDumper\VarDumper;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('users/index.html.twig');
    }

    /**
     * @Route("/data", name="users_data")
     * @IsGranted("ROLE_ADMIN")
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function data(UserRepository $userRepository, SerializerInterface $serializer, Request $request)
    {
        $users = $userRepository->findBy([], [], $request->get('limit', 10), $request->get('offset', 0));
        $totalUserCount = $userRepository->getCountTotalUsers();

        $response = $serializer->serialize(['items' => $users, 'count' => $totalUserCount], 'json', ['groups' => 'data-table']);

        return new Response($response, Response::HTTP_OK, ['content-type' => 'application/json']);
    }
}
