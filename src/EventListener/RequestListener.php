<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Psr\Log\LoggerInterface;

class RequestListener
{
    /**
     * @var string
     */
    private $environment;
    /**
     * @var array<String>
     */
    private $acceptable;

    public function __construct(
        private LoggerInterface $logger,
        string $environment,
        private string|null $accepts = ''
    ) {
        $this->environment = $environment;
        $this->acceptable = array('text/html', 'application/json');
    }

    private function jsonValidator(mixed $data): bool
    {
        if (!empty($data)) {
            return is_string($data) &&
                is_array(json_decode($data, true)) ? true : false;
        }
        return false;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $request = $event->getRequest();
        $accept = AcceptHeader::fromString($request->headers->get('Accept'));
        $this->logger->info((string)json_encode($accept));
        $intersect = array_intersect($this->acceptable, explode(',', $accept->__toString()));
        $this->accepts = preg_replace('/\s+/', '', !empty($intersect) ? (string)$accept : (string)$this->accepts);
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $response = $event->getResponse();
        $content = $response->getContent();
        $accept_string = implode(', ', $this->acceptable);
        $acceptHeader = AcceptHeader::fromString((string)$this->accepts);
        $interText  = $acceptHeader->has('text/html');
        $interJson  = $acceptHeader->has('application/json');
        $intersect  = $interText || $interJson;

        if (!$intersect) {
            throw new NotAcceptableHttpException('IODA is only accepting ' . $accept_string . ' at present!');
        } else {
            $isJson = $this->jsonValidator($content);
            if ($isJson && !$interJson) {
                throw new NotAcceptableHttpException("Content mismatch, add 'json/application' Accept header!");
            }
            if (!$isJson && !$interText) {
                throw new NotAcceptableHttpException("Content mismatch, please add 'text/html' Accept header!");
            }
            return;
        }
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $exception = $event->getThrowable();
        $content = [
            'code' => $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500,
            'message' => $exception->getMessage(),
            'trace' => \in_array($this->environment, ['dev', 'test'], true) ? $exception->getTrace() : []
        ];

        $event->setResponse(
            new JsonResponse($content, $content['code'])
        );
    }

    /**
     * @return (int|string)[][]
     *
     * @psalm-return array{'kernel.exception': list{'onKernelException', 200}}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 200],
        ];
    }
}
