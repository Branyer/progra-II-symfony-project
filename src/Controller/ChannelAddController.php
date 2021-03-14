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

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $channel = new Channel();



        $form = $this->createFormBuilder($channel)
            // ->add('name', TextType::class)
            ->add('name', TextType::class)
            ->add('programs', EntityType::class, [
                // looks for choices from this entity
                'class' => Program::class,
            
                // uses the User.username property as the visible option string
                'choice_label' =>  function ($Program) {
                    return $Program->getName();
                },
                'multiple' => true,
            
                // used to render a select box, check boxes or radios
                'expanded' => true,
                // 'checkboxes' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Create a Channel'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($channel);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }

        

        return $this->render('admin/services/channel.html.twig', [
            'ServicesForm' => $form->createView(),
            'name'=>'Edit an Cable Service',
        ]);
    }

    /**
     * @Route("/admin/services/channel/delete/{id}", name="delete_channel")
     */
    public function deleteChannel($id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Channel::class);
        $channel = $repository->find($id);
        
        if($channel) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($channel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_services');
    }
    
    /**
     * @Route("/admin/services/channel/edit/{id}", name="edit_channel")
     */
    public function editTelephony($id, EntityManagerInterface $em, Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Channel::class);
        $channel = $repository->find($id);

        $form = $this->createFormBuilder($channel)
            // ->add('name', TextType::class)
            ->add('name', TextType::class)
            ->add('programs', EntityType::class, [
                // looks for choices from this entity
                'class' => Program::class,
            
                // uses the User.username property as the visible option string
                'choice_label' =>  function ($Program) {
                    return $Program->getName();
                },
                'multiple' => true,
            
                // used to render a select box, check boxes or radios
                'expanded' => true,
                // 'checkboxes' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Create a Channel'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $channel->setName($form->get('name')->getData());

            $arr = $form->get('programs')->getData();

             foreach ($arr as $program) {
               $channel->removeProgram($program);
               $channel->addProgram($program);
            }

            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        
        return $this->render('admin/services/telephony.html.twig', [
            'ServicesForm' => $form->createView(),
            'name'=>'Edit an Telephony Service',
        ]);
    }
}
