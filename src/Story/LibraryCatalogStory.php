<?php

namespace App\Story;

use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use App\Factory\GenreFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;
use function array_map;

#[AsFixture('catalog')]
final class LibraryCatalogStory extends Story
{
     public function build(): void
     {
         $books = require dirname(__DIR__) . '/Story/data/book_fixtures.php';

         $admin = UserFactory::createOne(['email' => 'admin@example.com', 'roles' => ['ROLE_ADMIN']]);
         $reader = UserFactory::createOne(['email' => 'reader@example.com']);
         $manager = UserFactory::createOne(['email' => 'manager@example.com', 'roles' => ['ROLE_MANAGER']]);
         $librarian = UserFactory::createOne(['email' => 'librarian@example.com', 'roles' => ['ROLE_LIBRARIAN']]);
         $webmaster = UserFactory::createOne(['email' => 'webmaster@example.com', 'roles' => ['ROLE_WEBMASTER']]);
         $contributors = [$librarian, $reader, $manager];

         BookFactory::createMany(\count($books), static function (int $i) use ($books, $contributors) {

             // Sauvegarder les genres avant unset
             $genres = $books[$i - 1]['genres'];

             // Sauvegarder l'author avant unset
             $author = $books[$i - 1]['author'];

             // Supprimer les clés non mappées sur Book
             unset($books[$i - 1]['genres'], $books[$i - 1]['author']);

             return [
                 // Spread toutes les propriétés du livre
                 ...$books[$i - 1],

                 // findOrCreate : crée le genre s'il n'existe pas, le retrouve sinon
                 // → pas besoin de pré-créer les genres ni de map
                 'genres' => array_map(
                     static fn(string $name) => GenreFactory::findOrCreate(['name' => $name]),
                     $genres,
                 ),
                 'authors' => array_map(
                     static fn(string $name) => AuthorFactory::findOrCreate(['name' => $name]),
                     [$author],
                 ),
                 'addedBy' => $contributors[$i % 3],
             ];
         });
     }
}
