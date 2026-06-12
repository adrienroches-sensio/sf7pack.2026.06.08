<?php

declare(strict_types=1);

namespace App\Book\Event;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use function dump;

final class DumpCreatedBook
{
    #[AsEventListener()]
    public function __invoke(BookCreatedEvent $event): void
    {
        dump($event);
    }
}
