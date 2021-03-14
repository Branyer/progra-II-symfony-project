<?php

namespace App\Controller;

use App\Entity\ChangePackageRequest;
use App\Entity\Package;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminChangePackageRequestController extends AbstractController
{
    /**
     * @Route("/admin/change/package/request", name="admin_change_package_request")
     */
    public function index(): Response
    {

        $repository = $this->getDoctrine()->getRepository(ChangePackageRequest::class);
        $requests = $repository->findAll();

        return $this->render('admin_change_package_request/index.html.twig', [
            "changeRequests" => $requests 
        ]);
    }

    /**
     * @Route("/admin/change/package/request/accept/{id}", name="admin_change_package_request_accept")
     */
    public function acceptRequest($id): Response
    {

        $repositoryRequest = $this->getDoctrine()->getRepository(ChangePackageRequest::class);
        $request = $repositoryRequest->find($id);

        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repositoryUser->find($request->getUser()->getId());

        $repositoryPackage = $this->getDoctrine()->getRepository(Package::class);
        $package = $repositoryPackage->find($request->getPackage()->getId());

        $user->setPackage($package);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($request);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('home/index.html.twig');
    }
    /**
     * @Route("/admin/change/package/request/reject/{id}", name="admin_change_package_request_reject")
     */
    public function rejectRequest($id): Response
    {

        $repository = $this->getDoctrine()->getRepository(ChangePackageRequest::class);
        $request = $repository->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($request);
        $entityManager->flush();

        return $this->render('home/index.html.twig');
    }
}
