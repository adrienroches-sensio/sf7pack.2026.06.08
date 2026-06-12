<?php

declare(strict_types=1);

namespace App\Security\Voter\Book;

use App\Security\BookPermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

final class AllowIfLibrarianVoter implements VoterInterface
{
    public function __construct(
        private AccessDecisionManagerInterface $accessDecisionManager
    ) {
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        [$attribute] = $attributes;

        if (BookPermission::belongs($attribute) === false) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if ($this->accessDecisionManager->decide($token, ['ROLE_LIBRARIAN']) === false) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        return VoterInterface::ACCESS_GRANTED;
    }
}
