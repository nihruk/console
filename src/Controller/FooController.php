<?php

namespace App\Controller;

use App\Controller\ContentController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class FooController extends AbstractController implements ContentController
{
    #[Route('/pirates', name: 'pirates_index', methods: ["GET"])]
    public function bar(): Response
    {

        $data = [];
        $hards = [0, 1, 2, 3, 4];
        $names = ["Long John", "Cockle Jim", "Barnacle Bob", "Doubloon Doug", "Seasick Steve"];

        foreach ($hards as $hard) {
            $data[] = [
                'id' => $hard,
                'ref' => "PRT",
                'name' => $names[$hard],
                'description' => "High Seas Drifter"
            ];
        }
        return $this->json($data);
    }
}
