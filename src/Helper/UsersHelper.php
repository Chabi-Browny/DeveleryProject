<?php

namespace App\Helper;

use App\Entity\Users;

use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

/**
 * Description of UsersHelper
 */
class UsersHelper
{
    public static function getHashedPassword(string $plainPassword = null)
    {
        $hasherFactory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt']
        ]);

        $hasher = $hasherFactory->getPasswordHasher('common');

        return $hasher->hash($plainPassword);
    }
}
