<?php
declare (strict_types = 1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of ContactDT
 */
class ContactDto
{
    const NOTBLANK_DEFAULT = 'Hiba! Kérjük töltsd ki az összes mezőt!';

    public function __construct(
        #[Assert\NotBlank( message: self::NOTBLANK_DEFAULT)]
        #[Assert\Length(
            min: 5,
            max: 125,
            minMessage: 'A Név legalább {{ limit }} karakter hosszú legyen',
            maxMessage: 'A Név legfeljebb {{ limit }} karakter hosszú lehet',
        )]
        public readonly string $name,

        #[Assert\NotBlank( message: self::NOTBLANK_DEFAULT)]
        #[Assert\Length(
            min: 5,
            max: 125,
            minMessage: 'Az Email legalább {{ limit }} karakter hosszú legyen',
            maxMessage: 'Az Email legfeljebb {{ limit }} karakter hosszú lehet',
        )]
        #[Assert\Email(message: 'Hiba! Kérjük e-mail címet adjál meg!')]
        public readonly string $email,

        #[Assert\NotBlank( message: self::NOTBLANK_DEFAULT)]
        #[Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'Az Üzenet legalább {{ limit }} karakter hosszú legyen',
            maxMessage: 'Az Üzenet legfeljebb {{ limit }} karakter hosszú lehet',
        )]
        public readonly string $message
    ){}
}
