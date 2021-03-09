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

class InternetAddController extends AbstractController
{
    /**
     * @Route("/admin/services/internet", name="admin_services_internet")
     */
    public function adminService(EntityManagerInterface $em, Request $request): Response
    {
        $internet = new Internet();

        $form = $this->createFormBuilder($internet)
            ->add('speed', TextType::class)
            ->add('price', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Internet Plan'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($internet);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/internet.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }
}
