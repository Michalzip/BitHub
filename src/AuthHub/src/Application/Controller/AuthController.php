<?php

namespace App\Application\Controller;

use App\Domain\Repository\Test;
use  Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Command\SignUp\SignUpCommand;
use App\Application\Command\SignUp\SignUpHandler;
use App\Domain\Repository\AuthRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthController extends AbstractController
{

    #[Route('/api/sign-up',methods: ['POST'])]

    public function number(Request $request, SignUpHandler $kek) : Response
    {
        $data = json_decode($request->getContent(), true);

        $command = new SignUpCommand($data["firstName"],$data["lastName"],$data["email"],$data["password"]);

        $jd = $kek->signUp($command); 

        return new Response("add");

        
    }
}
