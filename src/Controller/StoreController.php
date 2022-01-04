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
use ProxyManager\ProxyGenerator\ValueHolder\MethodGenerator\Constructor;
use MongoDB\BSON\Timestamp;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\Query\AST\Functions\CurrentTimestampFunction;
use Doctrine\Common\Annotations\Annotation;
use DateTimeImmutable;
use App\Repository\ProductsRepository;
use App\Repository\ProductQtyRepository;
use App\Repository\OrdersRepository;
use App\Repository\CouponsRepository;
use App\Repository\CategoriesRepository;
use App\Form\ProductSearchType;
use App\Form\CouponsType;
use App\Form\CheckCouponType;
use App\Entity\Products;
use App\Entity\ProductQty;
use App\Entity\Orders;
use App\Entity\Coupons;

class StoreController extends AbstractController
{
    /**
     * variable de la classe StoreController
     * prend en entrée le montant de la reduction 
     * calculé avec le coupon
     *
     * @var float
     */
    private $value;

    /**
     * 
     * @Route("/{page<\d+>?1}", name="index")
     */
    public function index(CategoriesRepository $categorie, Request $request, ProductsRepository $prod ,SessionInterface $session, $page=1): Response
    {   
        //navigation entre les pages
        $limit = 15;
        $start = $page*$limit-$limit;
        $total = count($prod->findAll());
        $pages = ceil($total/$limit);
        // les produits à afficher
        $allproducts = $prod->findBy([],['created_at' => 'desc'],$limit,$start);
        $newAdd =  $prod->findBy([],['created_at' => 'desc'],5,0);
        // les categories à afficher
        $allCategories = $categorie->findAll();
        //indicateur de la navigation 
        $indicateur = [$start, $start+$limit, $total];

        //Search command
        $form = $this->createForm(ProductSearchType::class);
        
        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // On recherche les annonces correspondant aux mots clés
            $allproducts = $prod->search(
                $search->get('mots')->getData(),
                $search->get('categorie')->getData()
            );
        }

         // on initialise la session pour le cart

         $cart = $session->get("shoppingCart",[]);
         $cartUpdateTime = $session->get("AddToCartTime",[]) ;

         //On fabrique les données
         $cartData = [];
         $total = 0 ;

         $checkTime = time();
         if (empty($cartUpdateTime) ) {
             $cartUpdateTime =0;
         }
         
        //$this->del($session);

         if (($checkTime - ($cartUpdateTime + 24*3600) )>0 ) {
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
 
        

        return $this->render('store/shop.html.twig', [
            "products" => $allproducts,
            "cartData"=>$cartData,
             "total" => $total,
            "pages" =>$pages,
            "page"=>$page,
            "form"=> $form->createView(),
            "newAdd"=>$newAdd,
            "categories"=>$allCategories,
            "indicateur"=>$indicateur
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
       
        $form = $this->createForm(CheckCouponType::class);

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

        $result = $form ->handleRequest($request);
        $this->value = 0;
        $subTotal = 0;

        if ($form->isSubmitted() && $form->isValid()) {
            
            // Vérification du code saisie
            $submitCode  = $result->get("code")->getData();
            
            $allPromo = $reduce -> findAll();

            foreach($allPromo as $cp){
                if ($cp ->getCode() == $submitCode && $cp->getStatus() ) {
                    $this->value = ($total *$cp ->getValue())/100;
                } else {
                   $this->addFlash(
                      'warning',
                      'Votre code n\'est pas valide'
                   );
                }
                
            }

        }

        $subTotal = $total;
        $total -= $this->value;

        return $this->render('cart/cart.html.twig', ["cartData"=>$cartData, "total" => $total, "coupon" =>$form->createView(), "reduction"=>$this->value, "subtotal"=>$subTotal]);
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
        $updateTime = Time() ;
        $session->set("shoppingCart",$cart);
        $session->set("AddToCartTime",$updateTime);

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
       return $this->redirectToRoute("index");
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/commit", name="commit")
     */
    public function Command(ProductQtyRepository $qtyInfo, OrdersRepository $order, ProductsRepository $product, Request $request, SessionInterface $session,ObjectManager $entityManager): Response
    {   $order = new Orders(); 
        $cart = $session->get("shoppingCart",[]);
        
        foreach($cart as $id =>$quantity ){
            $Prod = $product->find($id);
            // Ajout du produit à la table commande;
            $order->addProduct($Prod);
            //update quantity produit
            $Prod->setQuantity( $Prod->getQuantity() - $quantity);
            // Collecte de la quantité commandé par produit acheté
            $qtyInfo = new ProductQty();
            $qtyInfo->setOrderId($order);
            $qtyInfo->setProduct($Prod);
            $qtyInfo->setQuantity($quantity);
            $entityManager->persist($qtyInfo);
           

        }

       $access = $this->isGranted("ROLE_USER");
       if ($access) {
           
           
           //$order -> setUser($this->getUser());
           $order -> setCreatedAt(new DateTimeImmutable('now'));
           // mise à jour des commandes utilisateurs
           $this->getUser()->addOrder($order);

           $entityManager->persist($order);
           $entityManager->flush();

           $this->addFlash(
            'success',
            'Merci d\'avoir payer nos produits'

        );
        $this->del($session);
   
           return $this->redirectToRoute("index");
          
       } else {
           return $this->redirectToRoute('app_login');
       }

    }

    /**
     * @Route("checkout", name="checkout")
     */
    public function checkout(SessionInterface $session, ProductsRepository $prod): Response
    {
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

        $subTotal = $total;
        $total -= $this->value;

       

        return $this->render('cart/checkout.html.twig', ["cartData"=>$cartData, "subtotal" => $subTotal, "total" => $total]);
    }
       
    
}
