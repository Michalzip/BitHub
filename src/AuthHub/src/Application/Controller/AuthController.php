<?php

namespace App\Application\Controller;

use OpenApi\Attributes as OA;
use App\Application\Dto\UserCreateDto;
use App\Application\Command\SignUp\Test;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Command\SignUp\SignUpCommand;
use App\Application\Command\SignUp\SignUpHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthController extends AbstractController
{
    #[Route('/api/sign-up', methods:['POST'])]

    #[OA\RequestBody(
        required: true,
        content:  new OA\JsonContent(ref: new Model(type: UserCreateDto::class))
    )]

    public function signUp(#[MapRequestPayload] UserCreateDto $user, SignUpHandler $handler): JsonResponse
    {

        $handler->signUp(new SignUpCommand($user->firstName, $user->lastName, $user->email, $user->password));

        return new JsonResponse(
            "user successfully created.",
            Response::HTTP_CREATED
        );
    }

}
