<?php

namespace App\Infrastructure\EventSubscriber;

use Throwable;
use Domain\Exception\UserNotFound;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Domain\Exception\Common\DomainException;
use App\Domain\Exception\InvalidAuthCredentials;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Domain\Exception\EmailAlreadyExistException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly array $exceptionToStatus = [])
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException', //subscribe kernelExcepction event.
        ];
    }
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse();

        $response->setStatusCode($this->determineStatusCode($exception));

        $response->setData($this->getErrorMessage($exception));

        $event->setResponse($response);
    }

    private function getErrorMessage(Throwable $exception): array
    {
        return
            $error = [
                'error' => [
                    'title' => \str_replace('\\', '.', $exception::class),
                    'detail' => $this->getExceptionMessage($exception),
                    'code' => $this->determineStatusCode($exception),
                ],
            ];
    }

    private function determineStatusCode(Throwable $exception): int
    {
        $exceptionClass = $exception::class;

        foreach ($this->exceptionToStatus as $class => $status) {

            if (\is_a($exceptionClass, $class, true)) {

                return $status;
            }
        }

        $statusCode = match (true) {
            $exception instanceof UserNotFound => Response::HTTP_NOT_FOUND,
            $exception instanceof EmailAlreadyExistException => Response::HTTP_CONFLICT,
            $exception instanceof InvalidAuthCredentials => Response::HTTP_UNAUTHORIZED,
            default =>  Response::HTTP_INTERNAL_SERVER_ERROR
        };

        // Default status code is always 500
        return $statusCode;
    }

    private function getExceptionMessage(Throwable $exception): string
    {
        return $exception->getMessage();
    }
}
