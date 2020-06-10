<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AfspraakRepository;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations= {"get","delete"},
 *     normalizationContext={"groups"="afspraak:read"},
 *     denormalizationContext={"groups"="afspraak:write"},
 *     attributes={
        "pagination_items_per_page"=10,
 *      "formats" = {"jsonld","json", "html","jsonhal","csv"={"text/csv"}}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={
        "Klant":"exact",
 *      "Klant.naam":"partial",
 *     "Klant.email":"partial",
 *     "datum":"partial",
 *     "Kapper":"exact",
 *      "Kapper.naam":"partial"
 *     })
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=AfspraakRepository::class)
 */
class Afspraak
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"afspraak:read","afspraak:write","klant:read","kapper:read","klant:write"})
     */
    private $notities;

    /**
     * @ORM\Column(type="date")
     * @Groups({"afspraak:read","afspraak:write","klant:read","kapper:read","klant:write"})
     * @Assert\NotBlank()
     */
    private $datum;

    /**
     * @ORM\Column(type="time")
     * @Groups({"afspraak:read","afspraak:write","klant:read","kapper:read","klant:write"})
     * @Assert\NotBlank()
     */
    private $begintijd;

    /**
     * @ORM\Column(type="time")
     * @Groups({"afspraak:read","afspraak:write","klant:read","kapper:read","klant:write"})
     * @Assert\NotBlank()
     */
    private $eindtijd;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"afspraak:read","kapper:read"})
     */

    private $bevestigd=false;

    /**
     * @ORM\Column(type="datetime")
     */

    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Klant::class, inversedBy="afspraken")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"afspraak:read","afspraak:write"})
     */
    private $Klant;

    /**
     * @ORM\ManyToOne(targetEntity=Kapper::class, inversedBy="afspraken")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"klant:read","afspraak:read","afspraak:write"})
     */
    private $Kapper;

    /**
     * @ORM\ManyToOne(targetEntity=DienstenKapper::class, inversedBy="afspraken")
     * @Groups({"afspraak:read","afspraak:write"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Dienst;


    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->Diensten = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotities(): ?string
    {
        return $this->notities;
    }

    public function setNotities(string $notities): self
    {
        $this->notities = $notities;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getBegintijd(): ?\DateTimeInterface
    {
        return $this->begintijd;
    }

    public function setBegintijd(\DateTimeInterface $begintijd): self
    {
        $this->begintijd = $begintijd;

        return $this;
    }

    public function setEindtijd(\DateTimeInterface $eindtijd): self
    {
        $this->eindtijd = $eindtijd;

        return $this;
    }

    public function getBevestigd(): ?bool
    {
        return $this->bevestigd;
    }

    public function setBevestigd(): self
    {
        $this->bevestigd = false;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @return string
     * @Groups({"kapper:read"})
     */

    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }

    public function getKlant(): ?Klant
    {
        return $this->Klant;
    }

    public function setKlant(?Klant $Klant): self
    {
        $this->Klant = $Klant;

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

    public function getDienst(): ?DienstenKapper
    {
        return $this->Dienst;
    }

    public function setDienst(?DienstenKapper $Dienst): self
    {
        $this->Dienst = $Dienst;

        return $this;
    }

    public function __toString()
    {
        return $this->notities;
    }

    public function getEindtijd(): ?\DateTimeInterface
    {
        return $this->eindtijd;
    }
}
