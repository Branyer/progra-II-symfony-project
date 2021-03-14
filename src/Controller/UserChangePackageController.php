<?php

namespace App\Controller;

use App\Entity\ChangePackageRequest;
use App\Entity\Package;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserChangePackageController extends AbstractController
{
    /**
     * @Route("/user/change/package/{id}", name="user_change_package")
     */
    public function index($id,  Request $request, EntityManagerInterface $em): Response
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);

        if(!$user->getPackage()) {
            return $this->redirectToRoute('home');
        }

        $prevId = $user->getPackage()->getId();

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
            },

            'data' => $user->getPackage(),
        ])
        ->add('save', SubmitType::class, ['label' => 'Send package change request'])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if($prevId !== $user->getPackage()->getId()) {

                $changeRequest = new ChangePackageRequest();
                $changeRequest->setUser($user);
                $changeRequest->setPackage($user->getPackage());

                $em->persist($changeRequest);
                $em->flush();
            }


            return $this->redirectToRoute('home');
        }

        return $this->render('user_change_package/index.html.twig', [
            'ServicesForm' => $form->createView(),
            'controller_name' => 'UserChangePackageController',
        ]);
    }
}
