<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    const MESSANGE_ERROR='Codigo o Nombre ya se encuentra Grabado';
    const MESSANGE_OK='Se ha Grabado el registro';
    const MESSANGE_ERROR_CHAR='No se permite Grabar datos con caracteres especiales ni espacios';
    const MESSANGE_ERROR_NAME='Campo debe contener minimo 4 y maximo 10 caracteres';
    const MESSANGE_DELETE='Se ha eliminado el registro!';
    const MESSANGE_UPDATE='Se ha modificado el registro!';
    const MESSANGE_ERROR_PRICE='Valor no es valido!';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_product;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_product;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description_product;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="product")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeProduct(): ?string
    {
        return $this->code_product;
    }

    public function setCodeProduct(string $code_product): self
    {
        $this->code_product = $code_product;

        return $this;
    }

    public function getNameProduct(): ?string
    {
        return $this->name_product;
    }

    public function setNameProduct(string $name_product): self
    {
        $this->name_product = $name_product;

        return $this;
    }

    public function getDescriptionProduct(): ?string
    {
        return $this->description_product;
    }

    public function setDescriptionProduct(string $description_product): self
    {
        $this->description_product = $description_product;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
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

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }
}
