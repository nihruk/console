<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Tangerine;

#[Route('/api', name: 'api_')]
class ContentNegotiationController extends AbstractController
{
    #[Route('/pirates', name: 'pirates_index', methods: ["GET"])]
    public function bar(): Response
    {

        $data = [];
        $ids = [0, 1, 2, 3, 4];
        $names = ["Long John", "Cockle Jim", "Barnacle Bob", "Doubloon Doug", "Seasick Steve"];
        $descriptions = [
            "Can drift for days",
            "Treasure finder",
            "Stuck to the ship",
            "A rare gem",
            "Always in the drink"
        ];

        foreach ($ids as $id) {
            $data[] = [
                'id' => $id,
                'ref' => "PRT",
                'name' => $names[$id],
                'description' => $descriptions[$id]
            ];
        }
        return $this->json($data);
    }

    #[Route('/pirates/text', name: 'pirates_text', methods: ["GET"])]
    public function boo(): Response
    {

        $textResponse = new Response("Pirates!", 200);
        $textResponse->headers->set('Content-Type', 'text/plain');

        return $textResponse;
    }

    #[Route('/five-hundred', name: 'five_index', methods: ["POST"])]
    public function fiveHundred(): Response
    {
        $tangerine = "mandarins";

        throw new Tangerine($tangerine);
    }
}
