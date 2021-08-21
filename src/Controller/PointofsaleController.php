<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\PointOfSale;
use App\Form\PointOfSaleType;
use App\Repository\PointOfSaleRepository;
use App\Form\PointOfType;

use Doctrine\ORM\EntityManagerInterface;

class PointofsaleController extends AbstractController
{
    /**
     * @Route("/", name="app_pointofsale_index", methods="GET")
     */
    public function index(PointOfSalerepository $posRepo): Response
    {
        $pointofsales = $posRepo->findBy([], ['createdAt' => "DESC"]);
        
        return $this->render('pointofsale/index.html.twig', [
                    'pointofsales' => $pointofsales
                ]);
    }

    /**
     * @Route("/point-of-sale/create", name="app_pointofsale_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $point_of_sale = new PointOfSale();
        $form = $this->createForm(PointOfSaleType::class, $point_of_sale);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $em->persist($point_of_sale);
            $em->flush();

            return $this->redirectToRoute('app_pointofsale_index');   
        }

        return $this->render('pointofsale/create.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/point-of-sale/{id<[0-9]+>}/edit", name="app_pointofsale_edit")
     */
    public function edit(Request $request, PointOfSale $pointOfSale, EntityManagerInterface $em)
    {
        $form = $this->createForm(PointOfSaleType::class, $pointOfSale, [
                    //'method' => 'PATCH'
                ]);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            $em->flush();

            return $this->redirectToRoute('app_pointofsale_index');
        }

        return $this->render('pointofsale/edit.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/point-of-sale/{id<[0-9]+>}", name="app_pointofsale_show")
     */
    public function show(PointOfSale $pointOfSale)
    {
        

        return $this->render('pointofsale/show.html.twig', compact('pointOfSale'));
    }

    /**
     * @Route("/point-of-sale/{id<[0-9]+>}/delete", name="app_pointofsale_delete")
     */
    public function delete(Request $request, PointOfSale $pointOfSale, EntityManagerInterface $em)
    {
        //dd($request->request->get('csrf_token'));//$request->request->all() : pour les données de types POST - $request->query->all() : pour les données de types GET 
        if( $this->isCsrfTokenValid('pos_deletion_'.$pointOfSale->getId(), $request->request->get('csrf_token')))
        {  
            $em->remove($pointOfSale);
            $em->flush();

        }
        return $this->redirectToRoute('app_pointofsale_index');
    }
}
