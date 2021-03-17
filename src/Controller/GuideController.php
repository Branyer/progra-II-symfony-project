<?php

namespace App\Controller;

use App\Entity\Channel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GuideController extends AbstractController
{


    /**
     * @Route("/user/guide", name="guide")
     */
    public function adminService(EntityManagerInterface $em, Request $request): Response
    {

        $ChanelRepository = $em->getRepository(Channel::class);
        $channel = $ChanelRepository->findAll();
        $type = $request->query->get("type");
        $find = $request->query->get("find");
        if ($type and $type == "1") {
            $r = array();
            $j = 0;
            for ($i = 0; $i < count($channel); $i++) {
                if (strpos($channel[$i]->getName(), $find) !== false) {
                    $r[$j] = $channel[$i];
                    $j++;
                }
            }
            $channel = $r;
        } else if ($type === "0") {
            $r = array();
            $k = 0;
            for ($i = 0; $i < count($channel); $i++) {
                $programs = $channel[$i]->getPrograms();
                for ($j = 0; $j < count($programs); $j++) {
                    if (strpos($programs[$j]->getName(), $find) !== false) {
                        $r[$k] = $channel[$i];
                        $k++;
                    }
                }
            }
            $channel = $r;
        }

        $url = array();
        $form = $this->createFormBuilder($url, array('allow_extra_fields' => true))
            // ->add('name', TextType::class)
            ->add('Find', TextType::class)
            ->add('Type', ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'expanded' => true,
                'choices' => [
                    'Program' => 0,
                    'Channel' => 1,
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Buscar'])
            ->getForm();
        $form->handleRequest($request);

        $hours = array();
        for ($i = 0; $i < 24; $i++) {
            $h = $i < 10 ? '0' . $i : $i;
            $s = '00';
            $hours[$i] = ($h . ':' . $s);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $auxFind = $form->get('Find')->getData();
            $auxType = $form->get('Type')->getData();
            var_dump($auxType);
            return $this->redirectToRoute('guide', ['type' => $auxType, 'find' => $auxFind]);
        }
        return $this->render(
            'guide/index.html.twig',
            [
                "channel" => $channel,
                "weekDay" => [
                    'Lun',
                    'Mar',
                    'Mié',
                    'Jue',
                    'Vie',
                    'Sáb',
                    'Dom',
                ],
                "hours" => $hours,
                'ServicesForm' => $form->createView(),
            ]
        );
    }
    /**
     * @Route("/user/guide", name="user_guide")
     */
    public function userService(EntityManagerInterface $em, Request $request): Response
    {

        $ChanelRepository = $em->getRepository(Channel::class);
        $channel = $ChanelRepository->findAll();
        $type = $request->query->get("type");
        $find = $request->query->get("find");
        if ($type and $type == "1") {
            $r = array();
            $j = 0;
            for ($i = 0; $i < count($channel); $i++) {
                if (strpos($channel[$i]->getName(), $find) !== false) {
                    $r[$j] = $channel[$i];
                    $j++;
                }
            }
            $channel = $r;
        } else if ($type === "0") {
            $r = array();
            $k = 0;
            for ($i = 0; $i < count($channel); $i++) {
                $programs = $channel[$i]->getPrograms();
                for ($j = 0; $j < count($programs); $j++) {
                    if (strpos($programs[$j]->getName(), $find) !== false) {
                        $r[$k] = $channel[$i];
                        $k++;
                    }
                }
            }
            $channel = $r;
        }

        $url = array();
        $form = $this->createFormBuilder($url, array('allow_extra_fields' => true))
            // ->add('name', TextType::class)
            ->add('Find', TextType::class)
            ->add('Type', ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'expanded' => true,
                'choices' => [
                    'Program' => 0,
                    'Channel' => 1,
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Buscar'])
            ->getForm();
        $form->handleRequest($request);

        $hours = array();
        for ($i = 0; $i < 24; $i++) {
            $h = $i < 10 ? '0' . $i : $i;
            $s = '00';
            $hours[$i] = ($h . ':' . $s);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $auxFind = $form->get('Find')->getData();
            $auxType = $form->get('Type')->getData();
            var_dump($auxType);
            return $this->redirectToRoute('guide', ['type' => $auxType, 'find' => $auxFind]);
        }
        return $this->render(
            'guide/index.html.twig',
            [
                "channel" => $channel,
                "weekDay" => [
                    'Lun',
                    'Mar',
                    'Mié',
                    'Jue',
                    'Vie',
                    'Sáb',
                    'Dom',
                ],
                "hours" => $hours,
                'ServicesForm' => $form->createView(),
            ]
        );
    }
}

