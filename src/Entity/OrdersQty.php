<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\OrdersQtyRepository;

/**
 * @ORM\Entity(repositoryClass=OrdersQtyRepository::class)
 */
class OrdersQty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $prodqty;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProdqty(): ?int
    {
        return $this->prodqty;
    }

    public function setProdqty(int $prodqty): self
    {
        $this->prodqty = $prodqty;

        return $this;
    }

    
}
