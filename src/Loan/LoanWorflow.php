<?php

declare(strict_types=1);

namespace App\Loan;

use App\Entity\Book;
use App\Entity\Loan;
use App\Entity\User;
use App\Repository\LoanRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final class LoanWorflow
{
    private const LOAN_DURATION = '+7 days';

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoanRepository $loanRepository,
    ) {
    }

    public function create(User $user, Book $book, DateTimeImmutable $loanDate): void
    {
        if ($book->isAvailable() === false) {
            throw LoanException::bookUnavailable($book);
        }

        $book->setAvailable(false);
        $this->entityManager->persist($book);

        $loan = new Loan();
        $loan->setBook($book);
        $loan->setUser($user);
        $loan->setLoanDate($loanDate);
        $loan->setDueDate($loanDate->modify(self::LOAN_DURATION));
        $loan->setStatus(LoanStatus::Active);

        $this->entityManager->persist($loan);
        $this->entityManager->flush();
    }

    public function return(Book $book, DateTimeImmutable $returnDate): void
    {
        if ($book->isAvailable() === true) {
            throw LoanException::bookAvailable($book);
        }

        $loan = $this->loanRepository->getActiveLoanByBookId($book->getId());
        $loan->setReturnDate($returnDate);
        $loan->setstatus(LoanStatus::Returned);

        $this->entityManager->persist($loan);

        $book->setAvailable(true);

        $this->entityManager->persist($book);
        $this->entityManager->flush();
    }
}
