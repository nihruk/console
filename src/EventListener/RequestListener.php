<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
        private string|null $accepts = ""
    ) {
        $this->environment = $environment;
        $this->acceptable = array("text/html", "application/json");
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $request = $event->getRequest();
        $accept = $request->headers->get("Accept");
        $this->logger->info((string)json_encode($this->accepts));
        $intersect = array_intersect($this->acceptable, explode(",", (string)$accept));
        $this->accepts = !empty($intersect) ? $accept : $this->accepts;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $response = $event->getResponse();
        if ($this->accepts !== "") {
            $response->headers->set("Content-Type", $this->accepts);
        } else {
            $accept_string = implode(', ', $this->acceptable);
            throw new AccessDeniedHttpException("IODA is only accepting {$accept_string} at present!");
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
