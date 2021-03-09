<?php

namespace App\Controller;

use App\Entity\Telephony;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TelephonyAddController extends AbstractController
{
    /**
     * @Route("/admin/services/telephony", name="admin_services_telephony")
     */
    public function adminService(EntityManagerInterface $em, Request $request): Response
    {
        $telephony = new Telephony();

        $form = $this->createFormBuilder($telephony)
            ->add('minutes', TextType::class)
            ->add('price', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create telephony Plan'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($telephony);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/telephony.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }
}
