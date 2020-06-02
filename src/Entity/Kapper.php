<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KapperRepository;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations= {"get","put","delete"},
 *     normalizationContext={"groups"="kapper:read"},
 *     denormalizationContext={"groups"="kapper:write"},
 *     attributes={
        "pagination_items_per_page"=10,
 *      "formats" = {"jsonld","json", "html","jsonhal","csv"={"text/csv"}}
 *     }
 *     )
 * @ORM\Entity(repositoryClass=KapperRepository::class)
 * * @ApiFilter(SearchFilter::class, properties={
        "naam":"partial",
 *      "postcode":"partial"
 *     })
 * @ApiFilter(PropertyFilter::class)
 * @UniqueEntity(fields={"email"})
 */
class Kapper
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"kapper:read","kapper:write","agenda:read","afspraak:read","klant:read"})
     */
    private $naam;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"kapper:read","kapper:write","agenda:read","dienstenKapper:read"})
     * @Assert\NotBlank()
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"kapper:read","kapper:write","afspraak:read"})
     * @Assert\NotBlank()
     */
    private $gemeente;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"kapper:read","kapper:write","afspraak:read"})
     * @Assert\NotBlank()
     */
    private $straat;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"kapper:read","kapper:write","afspraak:read"})
     * @Assert\NotBlank()
     */
    private $huisnr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"kapper:read","kapper:write","afspraak:read"})
     */
    private $busnr;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"kapper:read","kapper:write", "agenda:read","afspraak:read"})
     * @Assert\NotBlank()
     */
    private $telnr;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"kapper:read","kapper:write", "agenda:read","afspraak:read"})
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Agenda::class, mappedBy="Kapper", orphanRemoval=true)
     * @Groups({"kapper:read"})
     */
    private $agendas;

    /**
     * @ORM\OneToMany(targetEntity=Afspraak::class, mappedBy="Kapper")
     * @Groups({"kapper:read"})
     */
    private $afspraken;

    /**
     * @ORM\OneToMany(targetEntity=DienstenKapper::class, mappedBy="Kapper",orphanRemoval=true,cascade="persist")
     * @Groups({"kapper:read","kapper:write"})
     */
    private $dienstenKappers;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->agendas = new ArrayCollection();
        $this->afspraken = new ArrayCollection();
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

    public function getPostcode(): ?int
    {
        return $this->postcode;
    }

    public function setPostcode(int $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getGemeente(): ?string
    {
        return $this->gemeente;
    }

    public function setGemeente(string $gemeente): self
    {
        $this->gemeente = $gemeente;

        return $this;
    }

    public function getStraat(): ?string
    {
        return $this->straat;
    }

    public function setStraat(string $straat): self
    {
        $this->straat = $straat;

        return $this;
    }

    public function getHuisnr(): ?string
    {
        return $this->huisnr;
    }

    public function setHuisnr(string $huisnr): self
    {
        $this->huisnr = $huisnr;

        return $this;
    }

    public function getBusnr(): ?string
    {
        return $this->busnr;
    }

    public function setBusnr(?string $busnr): self
    {
        $this->busnr = $busnr;

        return $this;
    }

    public function getTelnr(): ?string
    {
        return $this->telnr;
    }

    public function setTelnr(string $telnr): self
    {
        $this->telnr = $telnr;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return string
     * @Groups({"kapper:read"})
     */

    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }

    /**
     * @return Collection|Agenda[]
     */
    public function getAgendas(): Collection
    {
        return $this->agendas;
    }

    public function addAgenda(Agenda $agenda): self
    {
        if (!$this->agendas->contains($agenda)) {
            $this->agendas[] = $agenda;
            $agenda->setKapper($this);
        }

        return $this;
    }

    public function removeAgenda(Agenda $agenda): self
    {
        if ($this->agendas->contains($agenda)) {
            $this->agendas->removeElement($agenda);
            // set the owning side to null (unless already changed)
            if ($agenda->getKapper() === $this) {
                $agenda->setKapper(null);
            }
        }

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
            $afspraken->setKapper($this);
        }

        return $this;
    }

    public function removeAfspraken(Afspraak $afspraken): self
    {
        if ($this->afspraken->contains($afspraken)) {
            $this->afspraken->removeElement($afspraken);
            // set the owning side to null (unless already changed)
            if ($afspraken->getKapper() === $this) {
                $afspraken->setKapper(null);
            }
        }

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
            $dienstenKapper->setKapper($this);
        }

        return $this;
    }

    public function removeDienstenKapper(DienstenKapper $dienstenKapper): self
    {
        if ($this->dienstenKappers->contains($dienstenKapper)) {
            $this->dienstenKappers->removeElement($dienstenKapper);
            // set the owning side to null (unless already changed)
            if ($dienstenKapper->getKapper() === $this) {
                $dienstenKapper->setKapper(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->naam;
    }
}
