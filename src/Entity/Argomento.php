<?php

namespace App\Entity;

use App\Repository\ArgomentoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArgomentoRepository::class)]
class Argomento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id= null;

    #[ORM\Column(length: 110, unique: true)]
    #[Assert\NotBlank(
        message: 'Questo campo non può essere lasciato vuoto'
    )]
    #[Assert\Length(
        max: 110,
        maxMessage: 'Nome troppo lungo',
        min: 4,
        minMessage: 'Nome troppo corto. Inserire un minimo di {{ min }} caratteri'
    )]
    private ?string $nome_argomento = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Testo troppo lungo',
        min: 10,
        minMessage: 'Testo troppo corto. Inserire un minimo di {{ min }} caratteri'
    )]
    private ?string $descrizione = null;

    /**
     * @var Collection<int, Domanda>
     */
    #[ORM\OneToMany(targetEntity: Domanda::class, mappedBy: 'argomento', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['testo_domanda' => 'ASC'])]

    private Collection $domandas;


    public function __construct()
    {
        $this->domandas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeArgomento(): ?string
    {
        return $this->nome_argomento;
    }

    public function setNomeArgomento(string $nome_argomento): static
    {
        $this->nome_argomento = $nome_argomento;

        return $this;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(string $descrizione): static
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    /**
     * @return Collection<int, Domanda>
     */
    public function getDomandas(): Collection
    {
        return $this->domandas;
    }

    public function addDomanda(Domanda $domanda): static
    {
        if (!$this->domandas->contains($domanda)) {
            $this->domandas->add($domanda);
            $domanda->setArgomento($this);
        }

        return $this;
    }

    public function removeDomanda(Domanda $domanda): static
    {
        if ($this->domandas->removeElement($domanda)) {
            // set the owning side to null (unless already changed)
            if ($domanda->getArgomento() === $this) {
                $domanda->setArgomento(null);
            }
        }

        return $this;
    }
}
