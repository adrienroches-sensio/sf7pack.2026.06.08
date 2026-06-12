<?php

declare(strict_types=1);

namespace App\Book\Event;

use App\Entity\Book;
use App\Entity\User;
use DateTimeImmutable;

final class BookCreatedEvent
{
    public function __construct(
        public readonly Book $book,
        public readonly User $user,
        public readonly DateTimeImmutable $createdAt,
    ) {
    }
}
