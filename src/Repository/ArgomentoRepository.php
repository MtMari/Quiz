<?php

namespace App\Repository;

use App\Entity\Argomento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\AST\CoalesceExpression;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;
/**
 * @extends ServiceEntityRepository<Argomento>
 */
class ArgomentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Argomento::class);
    }

    public function findAllConDomandas()
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('App\Entity\Domanda', 'd', Expr\Join::ON, 'd.argomento = a.id')
            ->where('d.argomento IS NOT NULL')
            ->orderBy('a.nome_argomento', Criteria::ASC)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllOrderedByNome()
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.nome_argomento', Criteria::ASC)
            ->getQuery()
            ->getResult()
        ;

        return $qb;
    }

    public function argomentoPerDomanda()
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('App\Entity\Domanda', 'd', Expr\Join::ON, 'd.argomento = a.id')
            ->addOrderBy('a.nome_argomento', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function argomentoPerNomeArgomento( string $nomeArgomento )
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('App\Entity\Domanda', 'd', Expr\Join::ON, 'd.argomento = a.id')
            ->where('a.nome_argomento=:argomento')
            ->setParameter('argomento', $nomeArgomento)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByQuery( string $query )
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('App\Entity\Domanda', 'd', Expr\Join::ON, 'd.argomento = a.id')
            ->addOrderBy('a.nome_argomento', 'ASC')
            ->addOrderBy('d.testo_domanda','ASC')
            ->where('LOWER(a.nome_argomento) LIKE LOWER(:query)')
            ->orWhere('d.testo_domanda=:query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findArgomentoByQuery( string $query )
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.nome_argomento', Criteria::ASC)
            ->leftJoin('App\Entity\Domanda', 'd', Expr\Join::ON, 'd.argomento = a.id')
            ->where('LOWER(a.nome_argomento) LIKE LOWER(:query)')
            ->orWhere('LOWER(a.descrizione) LIKE LOWER(:query)')
            ->setParameter('query', '%' . $query . '%')
            ->andWhere('d.argomento IS NOT NULL')
            ->getQuery()
            ->getResult()
        ;
    }
//    /**
//     * @return Argomento[] Returns an array of Argomento objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Argomento
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
