<?php

namespace App\Controller;

use App\Entity\Cable;
use App\Entity\Internet;
use App\Entity\Package;
use App\Entity\Telephony;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PackageAddController extends AbstractController
{
    /**
     * @Route("/admin/services/package", name="admin_services_package")
     */
    public function adminService(EntityManagerInterface $em, Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $package = new Package();

        $form = $this->createFormBuilder($package)
        ->add('Name', TextType::class)
        ->add('Internet', EntityType::class, [
            // looks for choices from this entity
            'class' => Internet::class,
        
            // uses the User.username property as the visible option string
            'choice_label' =>  function ($Internet) {
                return 'Speed: '.$Internet->getSpeed().'=>Price: '.$Internet->getPrice();
            },
            'placeholder' => 'Choose an option',
             'required' => false
        ])
        ->add('Telephony', EntityType::class, [
            // looks for choices from this entity
            'class' => Telephony::class,
        
            // uses the User.username property as the visible option string
            'choice_label' =>  function ($Telephony) {
                return 'Minutes: '.$Telephony->getMinutes().'=>Price: '.$Telephony->getPrice();
            },
            'placeholder' => 'Choose an option',
            'required' => false
        ])
        ->add('Cable', EntityType::class, [
            // looks for choices from this entity
            'class' => Cable::class,
        
            // uses the User.username property as the visible option string
            'choice_label' =>  function ($Cable) {
                return 'Plan: '.$Cable->getPlan()->getName().'=>Price: '.$Cable->getPrice();
            },

            'placeholder' => 'Choose an option',
            'required' => false
        ])
            ->add('discount', NumberType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Package'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($package);
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/package.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/services/package/delete/{id}", name="delete_package")
     */
    public function deleteInternet($id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(package::class);
        $package = $repository->find($id);
        
        if($package) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($package);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_services');

    }

    /**
     * @Route("/admin/services/package/edit/{id}", name="edit_package")
     */
    public function editInternet($id, EntityManagerInterface $em, Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null, 'User tried to access a page without having ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(Package::class);
        $package = $repository->find($id);

        $form = $this->createFormBuilder($package)
        ->add('Internet', EntityType::class, [
            // looks for choices from this entity
            'class' => Internet::class,
        
            // uses the User.username property as the visible option string
            'choice_label' =>  function ($Internet) {
                return 'Speed: '.$Internet->getSpeed().'=>Price: '.$Internet->getPrice();
            },
        ])
        ->add('Telephony', EntityType::class, [
            // looks for choices from this entity
            'class' => Telephony::class,
        
            // uses the User.username property as the visible option string
            'choice_label' =>  function ($Telephony) {
                return 'Minutes: '.$Telephony->getMinutes().'=>Price: '.$Telephony->getPrice();
            },
        ])
        ->add('Cable', EntityType::class, [
            // looks for choices from this entity
            'class' => Cable::class,
        
            // uses the User.username property as the visible option string
            'choice_label' =>  function ($Cable) {
                return 'Plan: '.$Cable->getPlan()->getName().'=>Price: '.$Cable->getPrice();
            },
        ])
            ->add('save', SubmitType::class, ['label' => 'Create Package'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $package->setInternet($form->get('Internet')->getData());
            $package->setTelephony($form->get('Telephony')->getData());
            $package->setCable($form->get('Cable')->getData());
            $em->flush();
            return $this->redirectToRoute('admin_services');
        }
        
        return $this->render('admin/services/package.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }
}
