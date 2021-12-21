<?php

namespace App\Controller;

use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\DataCollector\FormDataExtractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use MongoDB\BSON\Timestamp;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\Query\AST\Functions\CurrentTimestampFunction;
use DateTimeImmutable;
use App\Repository\ProductsRepository;
use App\Repository\OrdersRepository;
use App\Repository\CouponsRepository;
use App\Form\CouponsType;
use App\Entity\Products;
use App\Entity\Orders;
use App\Entity\Coupons;

class StoreController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index( ProductsRepository $prod ,SessionInterface $session): Response
    {   
        $allproducts = $prod->findAll();

         // on initialise la session pour le cart

         $cart = $session->get("shoppingCart",[]);
         $cartUpdateTime = $session->get("AddToCartTime",[]);

         //On fabrique les données
         $cartData = [];
         $total = 0 ;

         $checkTime = time();
         foreach ($cartUpdateTime as $tp){


         if (($checkTime - ($tp + 24*3600) )>0 ) {
            $this->del($session);
         } else {
             
            
             foreach ($cart as $id => $qty){
                 $product = $prod -> find($id);
                 $cartData [] = [
                     "product" => $product,
                     "quantity" => $qty
                 ];
     
                 $total +=$product->getPrice()*$qty;
             }
            
            
         }
 
        }

        return $this->render('store/shop.html.twig', [
            "products" => $allproducts,
            "cartData"=>$cartData,
             "total" => $total
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


    
    


    /**
     * @Route("/cart", name="cart")
     */
    public function cart( ProductsRepository $prod, SessionInterface $session, CouponsRepository $reduce, Request $request ): Response
    {    
        //formulaire pour récuperer les codes coupons
        $promo = new Coupons();
        $form = $this->createForm(CouponsType::class, $promo);

        // on initialise la session pour le cart

        $cart = $session->get("shoppingCart",[]);

        //On fabrique les données
        $cartData = [];
        $total = 0 ;

        foreach ($cart as $id => $qty){
            $product = $prod -> find($id);
            $cartData [] = [
                "product" => $product,
                "quantity" => $qty
            ];

            $total +=$product->getPrice()*$qty;
        }

        // validation du coupon

        $form ->handleRequest($request);
        $value = 0;
        $subTotal = 0;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Vérification du code saisie
            $submitCode = $data->getCode();
            $allPromo = $reduce -> findAll();

            foreach($allPromo as $cp){
                if ($cp ->getCode() == $submitCode && $cp->getStatus() ) {
                    $value = ($total *$cp ->getValue());
                } else {
                   $this->addFlash(
                      'warning',
                      'Votre code n\'est pas valide'
                   );
                }
                
            }

        }

        $subTotal = $total;
        $total -=$value;

        return $this->render('cart/cart.html.twig', ["cartData"=>$cartData, "total" => $total, "coupon" =>$form->createView(), "reduction"=>$value, "subtotal"=>$subTotal]);
    }


    /**
     * @Route("/add/{id}", name="cart_add")
     */
    public function cartAdd(SessionInterface $session, Products $prod): Response
    {
        $cart = $session->get("shoppingCart",[]);
        $updateTime = $session->get("AddToCartTime",[]);

        $id = $prod ->getId();
        if (!empty($cart[$id])){
            $cart[$id]++;
        }else {
            $cart[$id]=1;
        }

        // On sauvegarde la session shopping et l'heure de la derniere mise à jour
        $time = Time() ;
        $session->set("shoppingCart",$cart);
        $session->set("AddToCartTime",$time);

        return $this->redirectToRoute("cart");
        
    }

    
    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Products $product, SessionInterface $session): Response
    {
        // On recupère le cart actuel
         $cart = $session->get("shoppingCart",[]);
         $id = $product->getId();
         
         if (!empty($cart[$id])){
             if ($cart[$id] >1 ) {
                 $cart[$id]--;
                 
                } else {
                    unset($cart[$id]);
                }
                
            }

            // On sauvegarde la session
            $session->set("shoppingCart",$cart);
            return $this->redirectToRoute("cart");
        
    }

    /**
     * @Route("/delete/{id}", name="cart_delete")
     */
    public function deleteOne( Products $product, SessionInterface $session): Response
    {
        $cart = $session->get("shoppingCart",[]);
        $id = $product->getId();
        
        if (!empty($cart[$id])){   
            unset($cart[$id]);
           }

           // On sauvegarde la session
           $session->set("shoppingCart",$cart);
           return $this->redirectToRoute("cart");
    }

    /**
     * @Route("/delete_all", name="cart_delete_all")
     */
    public function del( SessionInterface $session): Response
    { 
        
       // On supprime la session
       $session->remove("shoppingCart");
       $session->remove("AddToCartTime");
       return $this->redirectToRoute("cart");
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/commit", name="commit")
     */
    public function Command(OrdersRepository $order, ProductsRepository $product, Request $request, SessionInterface $session,ObjectManager $entityManager): Response
    {   $order = new Orders(); 
        $cart = $session->get("shoppingCart",[]);
        
        foreach($cart as $id =>$quantity ){
            $Prod = $product->find($id);
            $order ->addProduct($Prod);
        }

       $access = $this->isGranted("ROLE_USER");
       if ($access) {
           
           
           $order -> setUser($this->getUser());
           $order -> setCreatedAt(new \DateTimeImmutable('now'));
           $entityManager->persist($order);
           $entityManager->flush();
   
           return $this->redirectToRoute("checkout");
          
       } else {
           return $this->redirectToRoute('app_login');
       }

    }

    /**
     * @Route("checkout", name="checkout")
     */
    public function checkout(): Response
    {
        return $this->render('cart/checkout.html.twig', []);
    }
       
    
}
