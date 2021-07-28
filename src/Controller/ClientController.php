<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client")
     */
    public function index(ClientRepository $repo): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_VENTE');

        $clients = $repo->findAll();

        return $this->render('client/index.html.twig', [
            "clients" => $clients,
        ]);
    }

    /**
     * @Route("/new2", name="client_new2")
     */
    public function client_new2(EntityManagerInterface $em, Request $request): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $cli = new Client();

        $form = $this->createForm(ClientFormType::class, $cli);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($cli);
            //$em->flush();

            $photo = $form->get("photo")->getData();
            $photo_name = uniqid("client_", true) . ".png";
            $photo->move("../photos", $photo_name);
            $cli->setPhoto($photo_name);
            $em->flush();

            return $this->redirect("/client");
        }

        return $this->render('client/new2.html.twig', [
            'controller_name' => 'ClientController',
            'formClient' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="client_new")
     */
    public function client_new(EntityManagerInterface $em, Request $request): Response
    {

        if ($request->getMethod()=="POST") {
            
            // même chose que $_POST["nom"]
            $nom = $request->request->get("nom");
            $prenom = $request->request->get("prenom");
            $cli = new Client();
            $cli->setNom($nom);
            $cli->setPrenom($prenom);

            $em->persist($cli);
            $em->flush();

            return $this->redirect("/client");
        }

        return $this->render('client/new.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * @Route("/pic/{client}", name="client_pic")
     */
    public function client_pic(Client $client): Response
    {

        //dd($client);

        return new BinaryFileResponse("../photos/" . $client->getPhoto());
    }
}
