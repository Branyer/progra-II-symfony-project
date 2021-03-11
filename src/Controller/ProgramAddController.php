<?php

namespace App\Controller;

use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $program = new Program();


        $form = $this->createFormBuilder($program, array('allow_extra_fields' => true))
            // ->add('name', TextType::class)
            ->add('name', TextType::class)
            ->add('hour', TimeType::class)

            ->add('WeekDay', ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'expanded' => true,
                'multiple' => true,
                'choices' => ['Lunes' => 'Lunes',
                             'Martes' => 'Martes',
                             'Miércoles' => 'Miercoles',
                             'Jueves' => 'Jueves',
                             'Viernes' => 'Viernes',
                             'Sábado' => 'Sabado',
                             'Domingo' => 'Domingo',],
            ])
            ->add('save', SubmitType::class, ['label' => 'Create program'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($form);
            // die();
            $em->persist($program);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/program.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }
}
