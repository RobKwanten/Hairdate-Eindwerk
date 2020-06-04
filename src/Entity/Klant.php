<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KlantRepository;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=KlantRepository::class)
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations= {"get", "put", "delete"},
 *     normalizationContext={"groups"="klant:read"},
 *     denormalizationContext={"groups"="klant:write"},
 *     attributes={
        "pagination_items_per_page"=10,
 *      "formats" = {"jsonld","json", "html","jsonhal","csv"={"text/csv"}}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={
        "naam":"partial",
 *      "postcode":"partial"
 *     })
 * @ApiFilter(PropertyFilter::class)
 * @UniqueEntity(fields={"email"})
 */
class Klant implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups({"klant:read"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"klant:read","klant:write","afspraak:read"})
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"klant:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"klant:read","klant:write","kapper:read"})
     * @Assert\NotBlank()
     */
    private $naam;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"klant:read","klant:write","afspraak:read","kapper:read"})
     * @Assert\NotBlank()
     */
    private $voornaam;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"klant:read","klant:write","afspraak:read"})
     * @Assert\NotBlank()
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"klant:read","klant:write"})
     * @Assert\NotBlank()
     */
    private $gemeente;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"klant:read","klant:write"})
     * @Assert\NotBlank()
     */
    private $straat;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"klant:read","klant:write"})
     * @Assert\NotBlank()
     */
    private $huisnr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"klant:read","klant:write"})
     */
    private $busnr;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"klant:read","klant:write","afspraak:read"})
     * @Assert\NotBlank()
     */
    private $telnr;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Afspraak::class, mappedBy="Klant",orphanRemoval=true)
     * @Groups({"klant:read"})
     */
    private $afspraken;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->afspraken = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getVoornaam(): ?string
    {
        return $this->voornaam;
    }

    public function setVoornaam(string $voornaam): self
    {
        $this->voornaam = $voornaam;

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

    public function getHuisnr(): ?int
    {
        return $this->huisnr;
    }

    public function setHuisnr(int $huisnr): self
    {
        $this->huisnr = $huisnr;

        return $this;
    }

    public function getBusnr(): ?int
    {
        return $this->busnr;
    }

    public function setBusnr(?int $busnr): self
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return string
     * @Groups({"klant:read"})
     */

    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
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
            $afspraken->setKlant($this);
        }

        return $this;
    }

    public function removeAfspraken(Afspraak $afspraken): self
    {
        if ($this->afspraken->contains($afspraken)) {
            $this->afspraken->removeElement($afspraken);
            // set the owning side to null (unless already changed)
            if ($afspraken->getKlant() === $this) {
                $afspraken->setKlant(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->voornaam." ".$this->naam;
    }
}
