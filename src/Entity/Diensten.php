<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DienstenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations= {"get","delete"},
 *     normalizationContext={"groups"="diensten:read"},
 *     denormalizationContext={"groups"="diensten:write"},
 *     attributes={
        "pagination_items_per_page"=10,
 *      "formats" = {"jsonld","json", "html","jsonhal","csv"={"text/csv"}}
 *     }
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ApiFilter(SearchFilter::class,properties={
        "naam":"partial"
 *     }
 *)
 * @ORM\Entity(repositoryClass=DienstenRepository::class)
 */
class Diensten
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"diensten:read","diensten:write","dienstenKapper:read","kapper:read","afspraak:read"})
     * @Assert\NotBlank()
     */
    private $naam;

    /**
     * @ORM\Column(type="text")
     * @Groups({"diensten:read","diensten:write","afspraak:read"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     max=150,
     *     maxMessage="Omschrijving mag maximaal 150 tekens bevatten."
     * )
     */
    private $omschrijving;

    /**
     * @ORM\OneToMany(targetEntity=DienstenKapper::class, mappedBy="Diensten", orphanRemoval=true)
     */
    private $dienstenKappers;

    public function __construct()
    {
        $this->dienstenKappers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getOmschrijving(): ?string
    {
        return $this->omschrijving;
    }

    public function setOmschrijving(string $omschrijving): self
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }


    /**
     * @return Collection|DienstenKapper[]
     */
    public function getDienstenKappers(): Collection
    {
        return $this->dienstenKappers;
    }

    public function addDienstenKapper(DienstenKapper $dienstenKapper): self
    {
        if (!$this->dienstenKappers->contains($dienstenKapper)) {
            $this->dienstenKappers[] = $dienstenKapper;
            $dienstenKapper->setDiensten($this);
        }

        return $this;
    }

    public function removeDienstenKapper(DienstenKapper $dienstenKapper): self
    {
        if ($this->dienstenKappers->contains($dienstenKapper)) {
            $this->dienstenKappers->removeElement($dienstenKapper);
            // set the owning side to null (unless already changed)
            if ($dienstenKapper->getDiensten() === $this) {
                $dienstenKapper->setDiensten(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->naam;
    }

}
