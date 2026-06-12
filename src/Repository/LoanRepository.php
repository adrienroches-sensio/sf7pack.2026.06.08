<?php

namespace App\Repository;

use App\Entity\Loan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Loan>
 */
class LoanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loan::class);
    }

    public function hasActiveLoanByBookId(int $bookId): bool
    {
        try {
            $this->getActiveLoanByBookId($bookId);

            return true;
        } catch (NoResultException) {
            return false;
        }
    }

    public function getActiveLoanByBookId(int $bookId): Loan
    {
        $qb = $this->createQueryBuilder('loan');

        $qb
            ->andwhere($qb->expr()->eq('loan.book', ':bookId'))
            ->setParameter('bookId', $bookId)
            ->andWhere($qb->expr()->isNull('loan.returnDate'))
        ;

        return $qb->getQuery()->getSingleResult();
    }

//    /**
//     * @return Loan[] Returns an array of Loan objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Loan
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
