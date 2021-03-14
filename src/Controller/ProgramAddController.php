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
                'choices' => ['Lunes' => 'Lun',
                             'Martes' => 'Mar',
                             'Miércoles' => 'Mie',
                             'Jueves' => 'Jue',
                             'Viernes' => 'Vie',
                             'Sábado' => 'Sab',
                             'Domingo' => 'Dom',],
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
            'name'=>'Create an Program',
        ]);
    }

    /**
     * @Route("/admin/services/program/delete/{id}", name="delete_program")
     */
    public function deleteTelephony($id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Program::class);
        $program = $repository->find($id);
        
        if($program) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($program);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_services');
    }
    
    /**
     * @Route("/admin/services/program/edit/{id}", name="edit_program")
     */
    public function editTelephony($id, EntityManagerInterface $em, Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Program::class);
        $program = $repository->find($id);

        $form = $this->createFormBuilder($program, array('allow_extra_fields' => true))
            // ->add('name', TextType::class)
            ->add('name', TextType::class)
            ->add('hour', TimeType::class)

            ->add('WeekDay', ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'expanded' => true,
                'multiple' => true,
                'choices' => ['Lunes' => 'Lun',
                             'Martes' => 'Mar',
                             'Miércoles' => 'Mie',
                             'Jueves' => 'Jue',
                             'Viernes' => 'Vie',
                             'Sábado' => 'Sab',
                             'Domingo' => 'Dom',],
            ])
            ->add('save', SubmitType::class, ['label' => 'Create program'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $program->setName($form->get('name')->getData());
            $program->setHour($form->get('hour')->getData());
            $program->setWeekDay($form->get('WeekDay')->getData());
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        
        return $this->render('admin/services/telephony.html.twig', [
            'ServicesForm' => $form->createView(),
            'name'=>'Edit an Telephony Service',
        ]);
    }
}
