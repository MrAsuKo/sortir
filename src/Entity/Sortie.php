<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 100)]
    private string $nom;

    #[ORM\Column(type: 'datetime')]
    private DateTime $dateHeureDebut;

    #[ORM\Column(type: 'integer')]
    private int $duree;

    #[ORM\Column(type: 'date')]
    private DateTime $dateLimiteInscription;

    #[ORM\Column(type: 'integer')]
    private int $nbInscriptionsMax;

    #[ORM\Column(type: 'string', length: 255)]
    private string $infosSortie;

    #[ORM\ManyToMany(targetEntity: Participant::class, inversedBy: 'sorties')]
    private $participants;

    #[ORM\ManyToOne(targetEntity: Participant::class, inversedBy: 'orgaSorties')]
    private Participant $organisateur;

    #[ORM\ManyToOne(targetEntity: Campus::class, inversedBy: 'sorties')]
    private Campus $campus;

    #[ORM\ManyToOne(targetEntity: Etat::class, inversedBy: 'sorties')]
    private Etat $etat;

    #[ORM\ManyToOne(targetEntity: Lieu::class, inversedBy: 'sorties')]
    private Lieu $lieu;

    #[Pure] public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDebut(): DateTime
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut( DateTime $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): DateTime
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription( DateTime $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): self
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipant(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participants): self
    {
        if (!$this->participants->contains($participants)) {
            $this->participants[] = $participants;
        }

        return $this;
    }

    public function removeParticipant(Participant $participants): self
    {
        $this->participants->removeElement($participants);

        return $this;
    }

    public function getOrganisateur(): ?Participant
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participant $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


}
