<?php

declare(strict_types=1);

namespace App\Loan;

use App\Entity\Book;
use RuntimeException;
use Throwable;

final class LoanException extends RuntimeException
{
    public const BOOK_UNAVAILABLE = 1;
    public const BOOK_AVAILABLE = self::BOOK_UNAVAILABLE << 1;

    public static function bookUnavailable(Book $book, Throwable|null $previous = null): LoanException
    {
        return new self(
            message: "Book '{$book->getTitle()}' is unavailable.",
            code: self::BOOK_UNAVAILABLE,
            previous: $previous,
        );
    }

    public static function bookAvailable(Book $book, Throwable|null $previous = null): LoanException
    {
        return new self(
            message: "Book '{$book->getTitle()}' is currently not loaned.",
            code: self::BOOK_AVAILABLE,
            previous: $previous,
        );
    }
}
