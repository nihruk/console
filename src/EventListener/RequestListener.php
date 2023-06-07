<?php

namespace App\EventListener;

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
        private string|null $accepts = ""
    ) {
        $this->environment = $environment;
        $this->acceptable = array("text/html", "application/json");
    }

    private function json_validator(mixed $data):bool {
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
        $accept = $request->headers->get("Accept");
        $this->logger->info((string)json_encode($this->accepts));
        $intersect = array_intersect($this->acceptable, explode(",", (string)$accept));
        $this->accepts = preg_replace('/\s+/', '', !empty($intersect) ? (string)$accept : (string)$this->accepts);
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $response = $event->getResponse();
        $accept_string = implode(', ', $this->acceptable);
        $content = $response->getContent();
        $intersect = array_intersect($this->acceptable, explode(",", (string)$this->accepts));
        $interText = array_intersect(["text/html"], explode(",", (string)$this->accepts));
        $interJson = array_intersect(["application/json"], explode(",", (string)$this->accepts));
        if (empty($intersect)) {
            throw new NotAcceptableHttpException("IODA is only accepting {$accept_string} at present!");
        } else {
            $isJson = $this->json_validator($content);
            if ($isJson && empty($interJson)) {
                throw new NotAcceptableHttpException("Content mismatch, please add 'json/application' Accept header!");
            }
            if (!$isJson && empty($interText)) {
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
