<?php

declare(strict_types=1);

namespace App\Application\Subscriber;

use App\Application\Response\ApiJsonResponse;
use App\Domain\Todo\Exception\DomainException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiResponseSubscriber implements EventSubscriberInterface
{
    /**
     * @var ApiJsonResponse
     */
    private $apiResponse;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ApiResponseSubscriber constructor.
     * @param ApiJsonResponse $response
     * @param RequestStack $requestStack
     * @param LoggerInterface $logger
     */
    public function __construct(ApiJsonResponse $response, RequestStack $requestStack, LoggerInterface $logger)
    {
        $this->apiResponse = $response;
        $this->requestStack = $requestStack;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [['onView']],
            KernelEvents::EXCEPTION => [['onException']]
        ];
    }

    public function onView(ViewEvent $event)
    {
        $value = $event->getControllerResult();
        $event->setResponse($this->apiResponse->createSuccessResponse($value));
    }

    public function onException(ExceptionEvent $event)
    {
        $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $ex = $event->getThrowable();
        if ($ex instanceof HttpException) {
            $httpCode = $ex->getStatusCode();
        }
        if ($ex instanceof DomainException) {
            $httpCode = $ex->getCode();
        }

        $this->logException($ex, $ex->getMessage());
        $event->setResponse(
            $this->apiResponse->createFromException($event->getThrowable(), $httpCode)
        );
    }

    /**
     * Logs an exception.
     *
     * @param \Throwable $exception The \Exception instance
     * @param string $message The error message to log
     */
    protected function logException(\Throwable $exception, $message)
    {
        $requestData = $_REQUEST;
        if ($request = $this->requestStack->getCurrentRequest()) {
            $jsonData = json_decode($request->getContent(), true);
            if (is_array($jsonData)) {
                $requestData = array_merge($requestData, $jsonData);
            }
        }

        $logData = [
            'request_uri' => $_SERVER['REQUEST_URI'] ?? '',
            'exception' => $exception,
            'request_data' => $requestData,
        ];

        if (!$exception instanceof HttpExceptionInterface || $exception->getStatusCode() >= 500) {
            $this->logger->critical($message, $logData);
        } else {
            $this->logger->info($message, $logData);
        }
    }
}