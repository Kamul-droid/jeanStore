<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\OrdersRepository;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Products::class, inversedBy="orders")
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity=ProductQty::class, mappedBy="ord")
     */
    private $productQties;

    

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->productQties = new ArrayCollection();
    }

   

    
    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        $this->product->removeElement($product);

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
            $productQty->setOrderId($this);
        }

        return $this;
    }

    public function removeProductQty(ProductQty $productQty): self
    {
        if ($this->productQties->removeElement($productQty)) {
            // set the owning side to null (unless already changed)
            if ($productQty->getOrderId() === $this) {
                $productQty->setOrderId(null);
            }
        }

        return $this;
    }

   
    
}
