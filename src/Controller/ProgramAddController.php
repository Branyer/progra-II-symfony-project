<?php

namespace App\Controller;

use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramAddController extends AbstractController
{
    /**
     * @Route("/admin/services/program", name="admin_services_program")
     */
    public function adminService(EntityManagerInterface $em, Request $request): Response
    {
        $program = new Program();

        $form = $this->createFormBuilder($program)
            // ->add('name', TextType::class)
            ->add('name', TextType::class)
            ->add('hour', TimeType::class)
            ->add('WeekDay', EntityType::class, [
                'class' => TextType::class,
                'choices' => ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo',],
            ])
            ->add('save', SubmitType::class, ['label' => 'Create program'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($program);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/program.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }
}
