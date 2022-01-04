<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CouponsRepository;
use App\Form\CouponsType;
use App\Entity\Coupons;

/**
 * @Route("/coupons")
 */
class CouponsController extends AbstractController
{
    /**
     * @Route("/", name="coupons_index", methods={"GET"})
     */
    public function index(CouponsRepository $couponsRepository): Response
    {
        return $this->render('coupons/index.html.twig', [
            'coupons' => $couponsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="coupons_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $coupon = new Coupons();
        $form = $this->createForm(CouponsType::class, $coupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coupon->setStatus(true);
            $entityManager->persist($coupon);
            $entityManager->flush();

            return $this->redirectToRoute('coupons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('coupons/new.html.twig', [
            'coupon' => $coupon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coupons_show", methods={"GET"})
     */
    public function show(Coupons $coupon): Response
    {
        return $this->render('coupons/show.html.twig', [
            'coupon' => $coupon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="coupons_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Coupons $coupon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CouponsType::class, $coupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('coupons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('coupons/edit.html.twig', [
            'coupon' => $coupon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coupons_delete", methods={"POST"})
     */
    public function delete(Request $request, Coupons $coupon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coupon->getId(), $request->request->get('_token'))) {
            $entityManager->remove($coupon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('coupons_index', [], Response::HTTP_SEE_OTHER);
    }
}
