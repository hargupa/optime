<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    const MESSANGE_ERROR='Codigo o Nombre ya se encuentra Grabado';
    const MESSANGE_OK='Se ha Grabado el registro';
    const MESSANGE_ERROR_CHAR='No se permite Grabar datos con caracteres especiales ni espacios';
    const MESSANGE_ERROR_NAME='El nombre debe ser minimo de 2 caracteres';
    const MESSANGE_DELETE='Se ha eliminado el registro!';
    const MESSANGE_UPDATE='Se ha modificado el registro!';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description_category;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="Category")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeCategory(): ?string
    {
        return $this->code_category;
    }

    public function setCodeCategory(string $code_category): self
    {
        $this->code_category = $code_category;

        return $this;
    }

    public function getNameCategory(): ?string
    {
        return $this->name_category;
    }

    public function setNameCategory(string $name_category): self
    {
        $this->name_category = $name_category;

        return $this;
    }

    public function getDescriptionCategory(): ?string
    {
        return $this->description_category;
    }

    public function setDescriptionCategory(string $description_category): self
    {
        $this->description_category = $description_category;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
