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

class ServicesAddController extends AbstractController
{
    /**
     * @Route("/admin/services/", name="admin_services")
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
            echo "Imprimir";
            $em->persist($internet);
            $em->flush();
            return $internet;
        }
        return $this->render('admin/services/index.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }
}
