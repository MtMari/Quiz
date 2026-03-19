<?php

namespace App\Entity;

use App\Repository\RispostaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RispostaRepository::class)]
class Risposta
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
        min: 2,
        minMessage: 'Testo troppo corto. Inserire un minimo di {{ min }} caratteri'
    )]
    private ?string $testo_risposta = null;

    #[ORM\Column]
    #[Assert\NotBlank(
        message: 'Questo campo non può essere lasciato vuoto'
    )]
    #[Assert\Range(
        min: -0,
        max: 1,
        notInRangeMessage: 'Il punteggio ha un valore compreso tra {{ min }} e {{ max }}',
    )]
    private ?int $punteggio = null;

    #[ORM\ManyToOne(inversedBy: 'rispostas')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false)]
    private ?Domanda $domanda = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestoRisposta(): ?string
    {
        return $this->testo_risposta;
    }

    public function setTestoRisposta(string $testo_risposta): static
    {
        $this->testo_risposta = $testo_risposta;

        return $this;
    }

    public function getPunteggio(): ?int
    {
        return $this->punteggio;
    }

    public function setPunteggio(int $punteggio): static
    {
        $this->punteggio = $punteggio;

        return $this;
    }

    public function getDomanda(): ?Domanda
    {
        return $this->domanda;
    }

    public function setDomanda(?Domanda $domanda): static
    {
        $this->domanda = $domanda;

        return $this;
    }
}
