<?php

namespace App\Repository;

use App\Entity\Domanda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @extends ServiceEntityRepository<Domanda>
 */
class DomandaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Domanda::class);
    }

    public function getRispostasCorrette( int $domandaId )
    {
        return $this->createQueryBuilder('d')
            ->select('r')
            ->join('App\Entity\Risposta', 'r', Expr\Join::ON, 'd.id = r.domanda')
            ->where('r.punteggio=1')
            ->andWhere('d.id = :id')
            ->setParameter('id', $domandaId )
            ->orderBy('r.testo_risposta', Criteria::ASC )
            ->getQuery()
            ->getResult()
        ;
    }

    public function getRispostasSbagliate( int $domandaId )
    {
        return $this->createQueryBuilder('d')
            ->select('r')
            ->join('App\Entity\Risposta', 'r', Expr\Join::ON, 'd.id = r.domanda')
            ->where('r.punteggio=0')
            ->andWhere('d.id = :id')
            ->setParameter('id', $domandaId )
            ->orderBy('r.testo_risposta', Criteria::ASC )
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDomandaByIdRisposta( int $idRisposta )
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->join('App\Entity\Risposta', 'r', Expr\Join::ON, 'd.id=r.domanda')
            ->where('r.id = :id')
            ->setParameter('id', $idRisposta)
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return Domanda[] Returns an array of Domanda objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Domanda
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
