<?php

declare(strict_types=1);

namespace App\Security\Voter\Book;

use App\Entity\Book;
use App\Repository\LoanRepository;
use App\Security\BookPermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use function in_array;

final class IsBookAlreadyLoanedVoter implements VoterInterface
{
    public function __construct(private LoanRepository $loanRepository)
    {
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        [$attribute] = $attributes;

        if (! in_array($attribute, [
            BookPermission::CHANGE_AVAILABILITY,
            BookPermission::REQUEST_LOAN,
        ], true)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if (! $subject instanceof Book) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if ($subject->isAvailable()) {
            return VoterInterface::ACCESS_GRANTED;
        }

//        if (! $this->loanRepository->hasActiveLoanByBookId($subject->getId())) {
//            return VoterInterface::ACCESS_GRANTED;
//        }

        return VoterInterface::ACCESS_ABSTAIN;
    }
}
