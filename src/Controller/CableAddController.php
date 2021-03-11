<?php

namespace App\Controller;

use App\Entity\Cable;
use App\Entity\Plan;
use App\Entity\Telephony;
use App\Repository\CableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CableAddController extends AbstractController
{
    /**
     * @Route("/admin/services/cable", name="admin_services_cable")
     */
    public function adminService(EntityManagerInterface $em, Request $request, CableRepository $cr): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $cable = new Cable();
        

        $form = $this->createFormBuilder($cable)
            ->add('Plan', EntityType::class, [
                // looks for choices from this entity
                'class' => Plan::class,
            
                // uses the User.username property as the visible option string
                'choice_label' =>  function ($Plan) {
                    return 'Name: '.$Plan->getName();
                },
                // 'multiple' => true,
            
                // used to render a select box, check boxes or radios
                // 'expanded' => true,
            ])
            ->add('Price', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create cable Plan'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($form);
            // die();
            $em->persist($cable);
            $em->flush();
            return $this->redirectToRoute('admin_services');
            
        }
        return $this->render('admin/services/cable.html.twig', [
            'ServicesForm' => $form->createView(),
            'name'=>'Create an Cable Service',
        ]);
    }

    /**
     * @Route("/admin/services/cable/delete/{id}", name="delete_cable")
     */
    public function deletePlan($id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Cable::class);
        $cable = $repository->find($id);

        if ($cable) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_services');
    }

    /**
     * @Route("/admin/services/cable/edit/{id}", name="edit_cable")
     */
    public function editCable($id, EntityManagerInterface $em, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Cable::class);
        $cable = $repository->find($id);

        $form = $this->createFormBuilder($cable)
            ->add('Plan', EntityType::class, [
                // looks for choices from this entity
                'class' => Plan::class,
            
                // uses the User.username property as the visible option string
                'choice_label' =>  function ($Plan) {
                    return 'Name: '.$Plan->getName();
                },
                // 'multiple' => true,
            
                // used to render a select box, check boxes or radios
                // 'expanded' => true,
            ])
            ->add('Price', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create cable Plan'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $cable->setPlan($form->get('Plan')->getData());
            $cable->setName($form->get('Name')->getData());
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }

        return $this->render('admin/services/internet.html.twig', [
            'ServicesForm' => $form->createView(),
            'name'=>'Edit an Cable Service',
        ]);
    }
}
