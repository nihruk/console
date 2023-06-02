<?php
// src/EventSubscriber/ContentSubscriber.php
namespace App\Middleware;

use App\Controller\ContentController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

use Psr\Log\LoggerInterface;
//https://gist.github.com/PurpleBooth/81705c8cd172a436c4c381cb41bc2861
class ContentNegotiation implements EventSubscriberInterface
{
    /**
     * @var EncoderInterface
     */
    private $serializer;

    /**
     * FormatFromAcceptListener constructor.
     *
     * @param EncoderInterface $serializer
     */
    public function __construct(
        EncoderInterface $serializer,
        private LoggerInterface $logger
    ) {
        $this->serializer = $serializer;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();
        // when a controller class defines multiple action methods, the controller
        // is returned as [$controllerInstance, 'methodName']
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof ContentController) {

            $namedArguments = $event->getRequest()->headers->get('Accept');
            // var_dump($response);
            $this->logger->info(json_encode($namedArguments));
            $request = $event->getRequest();
            $format = $request->get('_format');

            $this->logger->info(json_encode($format));
            
            $request->headers->set('Accept', 'application/json');
            if ($format == null) {
                $accepts = $request->getAcceptableContentTypes();

                $this->logger->info(json_encode($accepts));

                foreach ($accepts as $accept) {
                    $format = $request->getFormat($accept);

                    if ($format !== null && $this->serializer->supportsEncoding($format)) {
                        $request->attributes->set('_format', $format);

                        break;
                    }
                }
            }
            // throw new AccessDeniedHttpException('This action needs a valid token!');
            // throw new NotFoundHttpException('We could\'ne find it!');
            
        }
    }
    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->set("Content-Type", "application/json");
        // ... modify the response object
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
