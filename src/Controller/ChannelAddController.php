<?php

namespace App\Controller;

use App\Entity\Channel;
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

class ChannelAddController extends AbstractController
{
    /**
     * @Route("/admin/services/channel", name="admin_services_channel")
     */
    public function adminService(EntityManagerInterface $em, Request $request): Response
    {
        $channel = new Channel();

        $form = $this->createFormBuilder($channel)
            // ->add('name', TextType::class)
            ->add('name', TextType::class)
            ->add('Programation', EntityType::class, [
                // looks for choices from this entity
                'class' => Program::class,
            
                // uses the User.username property as the visible option string
                'choice_label' =>  function ($Program) {
                    return 'Name: '.$Program->getName();
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
            $em->persist($channel);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/channel.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }
}
