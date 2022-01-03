<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductQtyRepository;

/**
 * @ORM\Entity(repositoryClass=ProductQtyRepository::class)
 */
class ProductQty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="productQties",cascade={"persist"})
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Orders::class, inversedBy="productQties", cascade={"persist"})
     */
    private $ord;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOrderId(): ?Orders
    {
        return $this->ord;
    }

    public function setOrderId(?Orders $ord): self
    {
        $this->ord = $ord;

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
}
