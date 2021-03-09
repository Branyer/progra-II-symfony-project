<?php

namespace App\Controller;

use App\Entity\Internet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/admin/services/", name="admin_services")
     */
    public function adminService(EntityManagerInterface $em, Request $request): Response
    {
       
            return $this->render('admin/services/index.html.twig',[
                'status' => 0,
            ]);
      
    }
}