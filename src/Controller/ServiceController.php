<?php

namespace App\Controller;

use App\Entity\Cable;
use App\Entity\Channel;
use App\Entity\Internet;
use App\Entity\Package;
use App\Entity\Plan;
use App\Entity\Program;
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');
        
        $InternetRepository = $this->getDoctrine()->getRepository(Internet::class);
        $internet = $InternetRepository->findAll();
        
        $TelefoniaRepository = $this->getDoctrine()->getRepository(Telephony::class);
        $telefonia = $TelefoniaRepository->findAll();
        
        $CableRepository = $this->getDoctrine()->getRepository(Cable::class);
        $cable = $CableRepository->findAll();
        
        $ProgramRepository = $this->getDoctrine()->getRepository(Program::class);
        $program = $ProgramRepository->findAll();
        
        $ChanelRepository = $this->getDoctrine()->getRepository(Channel::class);
        $channel = $ChanelRepository->findAll();
        
        $PlanRepository = $this->getDoctrine()->getRepository(Plan::class);
        $plan = $PlanRepository->findAll();
        
        $PackageRepository = $this->getDoctrine()->getRepository(Package::class);
        $package = $PackageRepository->findAll();
        
            return $this->render('admin/services/index.html.twig',
            [
                "internet"=>$internet,
                "telefonia"=> $telefonia,
                "cable" => $cable,
                "program"=>$program,
                "channel"=>$channel,
                "plan"=>$plan,
                "package"=>$package,
            ]);
      
    }
}
