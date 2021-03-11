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
                    return 'Name: ' . $Channel->getName();
                },
                'multiple' => true,

                // used to render a select box, check boxes or radios
                // 'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Create program'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($form);
            // die();
            $em->persist($plan);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/plan.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }
}
