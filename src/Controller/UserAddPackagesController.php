<?php

namespace App\Controller;

use App\Entity\Package;
use App\Entity\User;
use App\Entity\Bill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAddPackagesController extends AbstractController
{
    /**
     * @Route("/user/add/packages/{id}", name="user_add_packages")
     */
    public function index($id,  Request $request, EntityManagerInterface $em ): Response
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);
        
        if($user->getPackage()){
                return $this->redirectToRoute('home');
        }

        $form = $this->createFormBuilder($user)
        ->add('package', EntityType::class, 
        [
            'class' => Package::class,
            'choice_label' =>  function ($package) {

                $internet =  $package->getInternet();
                $telephony =  $package->getTelephony();
                $cable =  $package->getCable();

                if($internet) {
                    $speed = $internet->getSpeed();
                    $internetString = "[Internet $speed]";
                } else {
                    $internetString = "";
                }

                if($telephony) {
                    $minutes = $telephony->getMinutes();
                    $telephonyString = "[Telephony $minutes]";
                } else {
                    $telephonyString = "";
                }

                if($cable) {
                    $plan = $cable->getPlan()->getName();
                    $cableString = "[Cable $plan]";
                } else {
                    $cableString = "";
                }
                return "$internetString $telephonyString $cableString";
            }
        ])
        ->add('save', SubmitType::class, ['label' => 'Add a Package'])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $bill = new Bill();
            $bill->setUser($user);
            $bill->setPackage($user->getPackage());

            $em->persist($user);
            $em->persist($bill);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        
        return $this->render('user_add_packages/index.html.twig', [
            'ServicesForm' => $form->createView(),
            'controller_name' => 'UserAddPackagesController',
        ]);
    }
}
