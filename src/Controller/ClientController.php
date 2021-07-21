<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(ClientRepository $repo): Response
    {
        $clients = $repo->findAll();

        return $this->render('client/index.html.twig', [
            "clients" => $clients,
        ]);
    }

    /**
     * @Route("/new", name="client_new")
     */
    public function client_new(EntityManagerInterface $em): Response
    {
        $cli = new Client();
        $cli->setNom("toto");
        $cli->setPrenom("titi");

        $em->persist($cli);
        $em->flush();

        return $this->render('client/new.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
