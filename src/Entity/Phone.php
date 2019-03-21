<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 * @JMS\ExclusionPolicy("all")
 * @Hateoas\Relation(
 *      "image",
 *      embedded= "expr(object.getImage())"
 *  )
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Expose
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $content;


    /**
     * @ORM\Column(type="datetime_immutable")
     * @JMS\Expose
     * @JMS\Type("DateTimeImmutable<'d/m/Y H:i:s'>")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose
     * @JMS\Type("integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Constructor", inversedBy="phones")
     * @ORM\JoinColumn(nullable=false)
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $constructor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="phones", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @JMS\Expose
     */
    private $categorie;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image")
     */
    private $image;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getConstructor(): ?Constructor
    {
        return $this->constructor;
    }

    public function setConstructor(?Constructor $constructor): self
    {
        $this->constructor = $constructor;

        return $this;
    }

    public function getCategorie(): ?Category
    {
        return $this->categorie;
    }

    public function setCategorie(?Category $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

}
