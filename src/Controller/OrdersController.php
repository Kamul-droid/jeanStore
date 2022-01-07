<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Options;
use Dompdf\Dompdf;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UsersRepository;
use App\Repository\OrdersRepository;
use App\Form\Orders1Type;
use App\Entity\Users;
use App\Entity\Orders;

/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods={"GET"})
     */
    public function index(OrdersRepository $ordersRepository): Response
    { 
        
        return $this->render('orders/index.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]);
    }

    /**
     * @param mixed $orders, $user
     * @Route("/user", name="user_order", methods={"GET"})
     */
    public function userOrd(UsersRepository $userep, OrdersRepository $repo): Response
    {
        $userInfo = $this->getUser();
        $orders = $repo->findAll();
        

        //On selctionne les informations concernant uniquement l'utilisateur connecté
        $userOrder = [] ;

        foreach ($orders as $key => $value) {
            
            //On compare l'id utilisateur de la table commande et l'id de l'utilisateur authentifié
            
            if ($userInfo != Null ) {
               
                if ($value->getUser()->getId() == $userInfo->getId() ) {
                    $userOrder [ $key] = $value;
                }
                
            }
        }
        return $this->render('orders/index.html.twig', [
            'orders' => $userOrder,
        ]);
    }

    /**
     * @Route("/new", name="orders_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Orders();
        $form = $this->createForm(Orders1Type::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orders/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orders_show", methods={"GET"})
     */
    public function show(Orders $order): Response
    {
        
        return $this->render('orders/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="orders_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Orders $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Orders1Type::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orders/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orders_delete", methods={"POST"})
     */
    public function delete(Request $request, Orders $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orders_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/recept/{id}", name="orders_receipt")
     */
    public function receipt(Orders $orders): Response
    {
        return $this->render('orders/recept.html.twig', ["order"=>$orders]);
    }

    /**
     * @param mixed $orders $pdfOptions
     * //Pdf creation
     * @Route("/pdf/{id}", name="orders_pdf", methods={"GET"})
     */
    public function pdFile(Orders $order): Response
    {
        $pdfOptions = new Options();
        $pdfOptions ->set("defaultFont","Arial");

        //Instanciation de Dompdf avec les options
        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('orders/show.html.twig', [
            "order" => $order,
        ]);
        // load HTML to dompdf
        $dompdf->loadHtml($html);

        // Setup the paper size and orinetation

        $dompdf->setPaper("A4","landscape");

        // render the Html as pdf

        $dompdf ->render();

        //Output the generated pdf to browser
        $dompdf->stream("jeanstore.pdf",["attachement"=>true]);
    }
}
