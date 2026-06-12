<?php

namespace App\Security;

enum BookPermission
{
    public const EDIT_DETAILS = 'book.edit_details';
    public const CHANGE_AVAILABILITY = 'book.change_availability';
    public const REQUEST_LOAN = 'book.request_loan';

    public static function belongs(string $permission): bool
    {
        return str_starts_with($permission, 'book.');
    }
}
