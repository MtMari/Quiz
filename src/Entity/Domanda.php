<?php

namespace App\Entity;

use App\Repository\DomandaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\OrderBy;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: DomandaRepository::class)]
class Domanda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Questo campo non può essere lasciato vuoto'
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Testo troppo lungo',
        min: 10,
        minMessage: 'Testo troppo corto. Inserire un minimo di {{ min }} caratteri'
    )]
    private ?string $testo_domanda = null;

    #[ORM\ManyToOne(inversedBy: 'domandas')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false)]
    #[Assert\NotBlank(
        message: 'Questo campo non può essere lasciato vuoto'
    )]
    private ?Argomento $argomento = null;

    /**
     * @var Collection<int, Risposta>
     */
    #[ORM\OneToMany(targetEntity: Risposta::class, mappedBy: 'domanda', orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[OrderBy(['testo_risposta' => 'ASC'])]
    #[Assert\Valid()]
    #[Assert\Count(
        min: 4,
        minMessage: 'Inserire un minimo di {{ limit }} risposte'
    )]
    private Collection $rispostas;


    public function __construct()
    {
        $this->rispostas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestoDomanda(): ?string
    {
        return $this->testo_domanda;
    }

    public function setTestoDomanda(string $testo_domanda): static
    {
        $this->testo_domanda = $testo_domanda;

        return $this;
    }

    public function getArgomento(): ?Argomento
    {
        return $this->argomento;
    }

    public function setArgomento(?Argomento $argomento): static
    {
        $this->argomento = $argomento;

        return $this;
    }

    /**
     * @return Collection<int, Risposta>
     */
    public function getRispostas(): Collection
    {
        return $this->rispostas;
    }

    public function addRisposta(Risposta $risposta): static
    {
        if (!$this->rispostas->contains($risposta)) {
            $this->rispostas->add($risposta);
            $risposta->setDomanda($this);
        }

        return $this;
    }

    public function removeRisposta(Risposta $risposta): static
    {
        if ($this->rispostas->removeElement($risposta)) {
            // set the owning side to null (unless already changed)
            if ($risposta->getDomanda() === $this) {
                $risposta->setDomanda(null);
            }
        }

        return $this;
    }
}
