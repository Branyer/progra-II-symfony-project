<?php

namespace App\Controller;

use App\Entity\Cable;
use App\Entity\Internet;
use App\Entity\Package;
use App\Entity\Telephony;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPackageController extends AbstractController
{
    /**
     * @Route("/user/package/{id}", name="user_package")
     */
    public function index($id): Response
    {

        $repositoryPackage = $this->getDoctrine()->getRepository(Package::class);
        $package = $repositoryPackage->find($id);

         $internet = null;
        if($package->getInternet()){
            $repositoryInternet = $this->getDoctrine()->getRepository(Internet::class);
            $internet = $repositoryInternet->find($package->getInternet()->getId());
        }

         $cable = null;
        if($package->getCable()){
            $repositoryCable = $this->getDoctrine()->getRepository(Cable::class);
            $cable = $repositoryCable->find($package->getCable()->getId());
        }

         $telephony = array();
        if($package->getTelephony()){
            $repositoryTelephony = $this->getDoctrine()->getRepository(Telephony::class);
            $telephony = $repositoryTelephony->find($package->getTelephony()->getId());
        }
        // print_r($telephony[0]);

        return $this->render('user_package/index.html.twig', [
            'package' => $package,
            'internet' => $internet,
            'telephony' => $telephony,
            'cable' => $cable,
        ]);
    }
}
