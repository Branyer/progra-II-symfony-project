<?php

namespace App\Controller;

use App\Entity\Telephony;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TelephonyAddController extends AbstractController
{
    /**
     * @Route("/admin/services/telephony", name="admin_services_telephony")
     */
    public function adminService(EntityManagerInterface $em, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $telephony = new Telephony();

        $form = $this->createFormBuilder($telephony)
            ->add('minutes', TextType::class)
            ->add('price', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create telephony Plan'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($telephony);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/telephony.html.twig', [
            'ServicesForm' => $form->createView(),
            'name'=>'Create an Telephony Service',
        ]);
    }

    /**
     * @Route("/admin/services/telephony/delete/{id}", name="delete_telephony")
     */
    public function deleteTelephony($id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Telephony::class);
        $telephony = $repository->find($id);
        
        if($telephony) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($telephony);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_services');
    }
    
    /**
     * @Route("/admin/services/telephony/edit/{id}", name="edit_telephony")
     */
    public function editTelephony($id, EntityManagerInterface $em, Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Telephony::class);
        $telephony = $repository->find($id);

        $form = $this->createFormBuilder($telephony)
            ->add('minutes', TextType::class)
            ->add('price', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Edit Telephony Plan'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $telephony->setMinutes($form->get('minutes')->getData());
            $telephony->setPrice($form->get('price')->getData());
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        
        return $this->render('admin/services/telephony.html.twig', [
            'ServicesForm' => $form->createView(),
            'name'=>'Edit an Telephony Service',
        ]);
    }
}
