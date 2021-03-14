<?php

namespace App\Controller;

use App\Entity\Bill;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBillsController extends AbstractController
{
    /**
     * @Route("/admin/bills", name="admin_bills")
     */
    public function index(): Response
    {

        $repository = $this->getDoctrine()->getRepository(Bill::class);
        $bills = $repository->findAll();

        return $this->render('admin_bills/index.html.twig', [
            'controller_name' => 'AdminBillsController',
            'bills' => array_reverse($bills)
        ]);
    }
}
