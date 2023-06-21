<?php

namespace App\Infrastructure\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

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
                    'code' => $exception->getCode(),
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

        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        // Default status code is always 500
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    private function getExceptionMessage(Throwable $exception): string
    {
        return $exception->getMessage();
    }
}
