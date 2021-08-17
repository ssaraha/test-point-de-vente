<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\PointOfSaleRepository;

class PointofsaleController extends AbstractController
{
    /**
     * @Route("/", name="pointofsale")
     */
    public function index(PointOfSalerepository $posRepo): Response
    {
        $pointofsales = $posRepo->findBy([], ['createdAt' => "DESC"]);
        
        return $this->render('pointofsale/index.html.twig', [
                    'pointofsales' => $pointofsales
                ]);
    }
}
