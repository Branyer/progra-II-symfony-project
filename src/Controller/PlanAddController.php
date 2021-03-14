<?php

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\Plan;
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

class PlanAddController extends AbstractController
{
    /**
     * @Route("/admin/services/plan", name="admin_services_plan")
     */
    public function adminService(EntityManagerInterface $em, Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $plan = new Plan();

        $form = $this->createFormBuilder($plan)
            // ->add('name', TextType::class)
            ->add('Name', TextType::class)
            ->add('Channels', EntityType::class, [
                // looks for choices from this entity
                'class' => Channel::class,

                // uses the User.username property as the visible option string
                'choice_label' =>  function ($Channel) {
                    return $Channel->getName();
                },
                'multiple' => true,
                'expanded' => true,
                // used to render a select box, check boxes or radios
                // 'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Cable Plan'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $em->persist($plan);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/plan.html.twig', [
            'ServicesForm' => $form->createView(),
            'name' =>'Create an TV Plan'
        ]);
    }

    /**
     * @Route("/admin/services/plan/delete/{id}", name="delete_plan")
     */
    public function deletePlan($id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Plan::class);
        $plan = $repository->find($id);
        
        if($plan) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_services');
    }
    
    /**
     * @Route("/admin/services/plan/edit/{id}", name="edit_plan")
     */
    public function editTelephony($id, EntityManagerInterface $em, Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(plan::class);
        $plan = $repository->find($id);

        $form = $this->createFormBuilder($plan)
            // ->add('name', TextType::class)
            ->add('Name', TextType::class)
            ->add('Channels', EntityType::class, [
                // looks for choices from this entity
                'class' => Channel::class,

                // uses the User.username property as the visible option string
                'choice_label' =>  function ($Channel) {
                    return $Channel->getName();
                },
                'multiple' => true,
                'expanded' => true,
                // used to render a select box, check boxes or radios
                // 'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Cable Plan'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $plan->setName($form->get('Name')->getData());
            $plan->addChannel($form->get('Channels')->getData());
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        
        return $this->render('admin/services/telephony.html.twig', [
            'ServicesForm' => $form->createView(),
            'name'=>'Edit an Telephony Service',
        ]);
    }
}
