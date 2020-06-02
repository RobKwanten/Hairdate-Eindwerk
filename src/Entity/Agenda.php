<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AgendaRepository;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get","post"},
 *     itemOperations= {"get","put", "delete"},
 *     normalizationContext={"groups"="agenda:read"},
 *     denormalizationContext={"groups":"agenda:write"},
 *     attributes={
        "pagination_items_per_page"=10,
 *      "formats" = {"jsonld","json", "html","jsonhal","csv"={"text/csv"}}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={
 *     "Kapper":"exact",
        "Kapper.naam":"partial"
 *     })
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=AgendaRepository::class)
 */
class Agenda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"agenda:read","agenda:write","kapper:read"})
     * @Assert\NotBlank()
     */
    private $datum;

    /**
     * @ORM\Column(type="time")
     * @Groups({"agenda:read","agenda:write","kapper:read"})
     * @Assert\NotBlank()
     */
    private $openingstijd;

    /**
     * @ORM\Column(type="time")
     * @Groups({"agenda:read","agenda:write","kapper:read"})
     * @Assert\NotBlank()
     */
    private $sluitingstijd;

    /**
     * @ORM\ManyToOne(targetEntity=Kapper::class, inversedBy="agendas")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"agenda:read","agenda:write"})
     */
    private $Kapper;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOpeningstijd(): ?\DateTimeInterface
    {
        return $this->openingstijd;
    }

    public function setOpeningstijd(\DateTimeInterface $openingstijd): self
    {
        $this->openingstijd = $openingstijd;

        return $this;
    }

    public function getSluitingstijd(): ?\DateTimeInterface
    {
        return $this->sluitingstijd;
    }

    public function setSluitingstijd(\DateTimeInterface $sluitingstijd): self
    {
        $this->sluitingstijd = $sluitingstijd;

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
}
