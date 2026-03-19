<?php

namespace App\Repository;

use App\Entity\Risposta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;
/**
 * @extends ServiceEntityRepository<Risposta>
 */
class RispostaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Risposta::class);
    }
    public function getRispostasCorrette()
    {
        return $this->createQueryBuilder('r')
            ->join('App\Entity\Domanda', 'd', Expr\Join::ON, 'd.id = r.domanda')
            ->where('r.punteggio=1')
            ->orderBy('r.testo_risposta', Criteria::ASC )
            ->getQuery()
            ->getResult()
        ;
    }
//    /**
//     * @return Risposta[] Returns an array of Risposta objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Risposta
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
