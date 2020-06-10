<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DienstenKapperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations= {"get","put","delete"},
 *     normalizationContext={"groups"="dienstenKapper:read"},
 *     denormalizationContext={"groups"="dienstenKapper:write"},
 *     attributes={
        "pagination_items_per_page"=10,
 *      "formats" = {"jsonld","json", "html","jsonhal","csv"={"text/csv"}}
 *     }
 * )
 * @ApiFilter(SearchFilter::class,properties={
        "Kapper":"exact",
 *     "Kapper.naam":"partial"
 *     })
 * @ORM\Entity(repositoryClass=DienstenKapperRepository::class)
 */
class DienstenKapper
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"dienstenKapper:read","kapper:read","afspraak:read"})
     */

    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"dienstenKapper:read","dienstenKapper:write","kapper:read","kapper:write","afspraak:read"})
     * @Assert\NotBlank()
     */
    private $duur;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"dienstenKapper:read","dienstenKapper:write","kapper:read","kapper:write","afspraak:read"})
     * @Assert\NotBlank()
     */
    private $prijs;

    /**
     * @ORM\ManyToOne(targetEntity=Diensten::class, inversedBy="dienstenKappers")
     * @Groups({"dienstenKapper:read","dienstenKapper:write","kapper:write","kapper:read","afspraak:read"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Diensten;

    /**
     * @ORM\ManyToOne(targetEntity=Kapper::class, inversedBy="dienstenKappers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dienstenKapper:read","dienstenKapper:write"})
     */
    private $Kapper;

    /**
     * @ORM\OneToMany(targetEntity=Afspraak::class, mappedBy="Dienst")
     */
    private $afspraken;

    private $hallo = "hallo";

    public function __construct()
    {
        $this->Afspraken = new ArrayCollection();
        $this->afspraken = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuur(): ?int
    {
        return $this->duur;
    }

    public function setDuur(int $duur): self
    {
        $this->duur = $duur;

        return $this;
    }

    public function getPrijs(): ?int
    {
        return $this->prijs;
    }

    public function setPrijs(int $prijs): self
    {
        $this->prijs = $prijs;

        return $this;
    }

    public function getDiensten(): ?Diensten
    {
        return $this->Diensten;
    }

    public function setDiensten(?Diensten $Diensten): self
    {
        $this->Diensten = $Diensten;

        return $this;
    }

    public function getKapper(): ?Kapper
    {
        return $this->Kapper;
    }

    public function setKapper(?Kapper $Kapper): self
    {
        $this->Kapper = $Kapper;

        return $this;
    }

    /**
     * @return Collection|Afspraak[]
     */
    public function getAfspraken(): Collection
    {
        return $this->afspraken;
    }

    public function addAfspraken(Afspraak $afspraken): self
    {
        if (!$this->afspraken->contains($afspraken)) {
            $this->afspraken[] = $afspraken;
            $afspraken->setDienst($this);
        }

        return $this;
    }

    public function removeAfspraken(Afspraak $afspraken): self
    {
        if ($this->afspraken->contains($afspraken)) {
            $this->afspraken->removeElement($afspraken);
            // set the owning side to null (unless already changed)
            if ($afspraken->getDienst() === $this) {
                $afspraken->setDienst(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->hallo;
    }
}
