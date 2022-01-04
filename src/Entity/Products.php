<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\ProductsRepository;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 * @ORM\Table(name="products", indexes={@ORM\Index(columns={"name"}, flags={"fulltext"})})
 *
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="product", orphanRemoval=true, cascade = {"persist"})
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity=Orders::class, mappedBy="product")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=ProductQty::class, mappedBy="product")
     */
    private $productQties;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="products")
     */
    private $categorie;

   

   

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->productQties = new ArrayCollection();
        
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

   

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }



    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addProduct($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            $order->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|ProductQty[]
     */
    public function getProductQties(): Collection
    {
        return $this->productQties;
    }

    public function addProductQty(ProductQty $productQty): self
    {
        if (!$this->productQties->contains($productQty)) {
            $this->productQties[] = $productQty;
            $productQty->setProduct($this);
        }

        return $this;
    }

    public function removeProductQty(ProductQty $productQty): self
    {
        if ($this->productQties->removeElement($productQty)) {
            // set the owning side to null (unless already changed)
            if ($productQty->getProduct() === $this) {
                $productQty->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

  

    
}
