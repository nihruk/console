<?php

// src/EventListener/RequestListener.php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Psr\Log\LoggerInterface;
// https://symfony.com/doc/current/components/http_foundation.html
class RequestListener
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $accepts = $request->getAcceptableContentTypes();
        $this->logger->info((string)json_encode($accepts));
        $request->headers->set("Accept" , "application/json");
        
        $accepts = $request->getAcceptableContentTypes();
        $this->logger->info((string)json_encode($accepts));
        // $this->logger->info($request);
       
    }
    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        $response = $event->getResponse();
        // Set multiple headers simultaneously
        $response->headers->add([
            'Header-Name1' => 'value',
            'Header-Name2' => 'ExampleValue'
        ]);

        // Or set a single header
        $response->headers->set("Content-Type", "application/json");
    }

   
}
