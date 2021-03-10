<?php

namespace App\Controller;

use App\Entity\Cable;
use App\Entity\Internet;
use App\Entity\Telephony;
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
       
        
        $InternetRepository = $this->getDoctrine()->getRepository(Internet::class);
        $internet = $InternetRepository->findAll();
        
        $TelefoniaRepository = $this->getDoctrine()->getRepository(Telephony::class);
        $telefonia = $TelefoniaRepository->findAll();
        
        $CableRepository = $this->getDoctrine()->getRepository(Cable::class);
        $cable = $CableRepository->findAll();
        
        //TODO buscar servicio de cable

            return $this->render('admin/services/index.html.twig',
            [
                "internet"=>$internet,
                "telefonia"=> $telefonia,
                "cable" => $cable,
            ]);
      
    }
}
