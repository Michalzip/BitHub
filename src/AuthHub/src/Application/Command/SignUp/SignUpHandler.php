<?php

namespace App\Application\Command\SignUp;

use App\Domain\Exception\AlreadyExistsException;
use App\Application\Command\SignUp\SignUpCommand;
use App\Domain\Repository\AuthRepositoryInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class SignUpHandler
{

    public function __construct( private AuthRepositoryInterface $authRepository)
    {
    }

    public function SignUp(SignUpCommand $command){

        $userData = $this->authRepository->createUser($command);
        
        $validData = $this->authRepository->checkUserExistByEmail($userData->getEmail());

            if(null !== $validData) throw new AlreadyExistsException();

     
        $this->authRepository->saveUser($userData);

    
    }
}
