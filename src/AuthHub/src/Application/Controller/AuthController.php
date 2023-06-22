<?php

namespace App\Application\Controller;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Command\SignIn\SignInCommand;
use App\Application\Command\SignIn\SignInHandler;
use App\Application\Command\SignUp\SignUpCommand;
use App\Application\Command\SignUp\SignUpHandler;
use App\Application\Dto\UserSignUpDto;
use App\Application\Dto\UserSignInDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthController extends AbstractController
{
    #[Route('/api/sign-up', methods:['POST'])]
    #[OA\RequestBody(
        required: true,
        content:  new OA\JsonContent(ref: new Model(type: UserSignUpDto::class))
    )]

    public function signUp(#[MapRequestPayload] UserSignUpDto $data, SignUpHandler $handler): JsonResponse
    {

        $handler->handle(new SignUpCommand($data->firstName, $data->lastName, $data->email, $data->password));

        return new JsonResponse(
            "user successfully created.",
            Response::HTTP_CREATED
        );
    }

    #[Route('/api/sign-in', methods:['POST'])]
    #[OA\RequestBody(
        required: true,
        content:  new OA\JsonContent(ref: new Model(type: UserSignInDto::class))
    )]

    public function signIn(#[MapRequestPayload] UserSignInDto $data, SignInHandler $handler): JsonResponse
    {

        $handler->handle(new SignInCommand($data->email, $data->password));

        return new JsonResponse(
            "user successfully sign in.",
            Response::HTTP_OK
        );
    }

}
