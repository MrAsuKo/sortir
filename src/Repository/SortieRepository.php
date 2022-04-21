<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }


    public function add(Sortie $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush)
        {
            $this->_em->flush();
        }
    }


    public function remove(Sortie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush)
        {
            $this->_em->flush();
        }
    }

    public function Filter( $criteria )
    {
        $qb = $this->createQueryBuilder('s');
            if ( $criteria['campus'])
            {
                $qb
                ->andWhere('s.campus = :campus')
                ->setParameter('campus', $criteria['campus']);
            }

            if( $criteria['nom'] )
            {
                $qb
                ->andWhere( 's.nom LIKE :nom')
                ->setParameter('nom', '%'.$criteria['nom'].'%');
            }

                /*$qb
                ->innerJoin(Participant::class, 'p', Join::WITH, 'p = s.participants')
                ->andWhere( 'p.nom = :user')
                ->setParameter('user', 'titi');*/



            return
            $qb
            ->andWhere('s.dateHeureDebut > :debut')
            ->setParameter('debut', $criteria['dateHeureDebut'])
            ->andWhere('s.dateHeureDebut < :fin')
            ->setParameter('fin', $criteria['dateHeureFin'])

            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
