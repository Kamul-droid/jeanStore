<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductsRepository;
use App\Form\ProductsType;
use App\Form\ImageType;
use App\Entity\Products;
use App\Entity\Image;

/**
 * @Route("/products")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("/", name="products_index", methods={"GET"})
     */
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="products_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Products();
       

        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newImg = $form ->get('image')->getData();

             // on boucle sur les images
             foreach($newImg as $img){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$img->guessExtension();

                //On copie le fichier dans le dossier indiqué
                //move_uploaded_file($fichier,'images_directory');
                $img->move($this->getParameter('images_directory'),$fichier);
                
                // On stocke l´image dans la base de données Articles
                $Image = new Image();
                $Image -> setLink($fichier);
                $Image -> setProduct($product);
                $product -> addImage($Image);

            }
              // recharge la page si le contenu n'est pas saisi
              $formContent = $form->get('name')->getData();
              $formContent1 = $form->get('price')->getData();
            if(!$formContent && !$formContent1){
              return $this->redirectToRoute('products_new', [], Response::HTTP_SEE_OTHER);
            }
            
            $product->setCreatedAt(new \DateTimeImmutable('now'));

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="products_show", methods={"GET"})
     */
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="products_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="products_delete", methods={"POST"})
     */
    public function delete(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('products_index', [], Response::HTTP_SEE_OTHER);
    }
}
