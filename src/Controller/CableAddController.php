<?php

namespace App\Controller;

use App\Entity\Cable;
use App\Repository\CableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
        $cable = new Cable();

        

        $form = $this->createFormBuilder($cable)
            // ->add('plan', CollectionType::class, array(
            //     'entry_type' => EmailType::class,
            //     // these options are passed to each "email" type
            //     'entry_options' => [
            //     'attr' => ['class' => 'email-box'],
            //  ))
            ->add('plan', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'choices'  => [
                        'Nashville' => 'nashville',
                        'Paris'     => 'paris',
                        'Berlin'    => 'berlin',
                        'London'    => 'london',
                    ],
                ],
            ])
            ->add('price', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create cable Plan'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($cable);
            $em->flush();
            // return $this->redirectToRoute('admin_services');
            $data = $cr->findAll();

            $response = New JsonResponse();
            $response->setData([
                'success'=>true,
                'data'=>$data,
            ]);
            return $response;
        }
        return $this->render('admin/services/cable.html.twig', [
            'ServicesForm' => $form->createView(),
        ]);
    }
}
