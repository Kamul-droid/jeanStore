<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('store/index.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }


    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('store/about.html.twig', []);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('store/contact.html.twig', []);
    }

    /**
     * @Route("/politique", name="politique")
     */
    public function politique(): Response
    {
        return $this->render('store/politique.html.twig', []);
    }

    /**
     * @Route("/confidentialite", name="confidentialite")
     */
    public function confid(): Response
    {
        return $this->render('store/confidentialite.html.twig', []);
    }

    /**
     * @Route("/admin", name="admin_index")
     */
    public function admin(): Response
    {
        return $this->render('store/admin.html.twig', []);
    }
    /**
     * @Route("/boutique", name="boutique")
     */
    public function shop(): Response
    {
        return $this->render('store/index.html.twig', []);
    }
}
