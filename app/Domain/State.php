<?php

declare(strict_types=1);

namespace App\Domain;

enum State : string
{
    case Draft = 'Brouillon';
    case Published = 'Publié';
    case Hidden = 'Masqué';
    case Invisible = 'Invisible';

    // @todo à enlever apres implémentation de la persistence avec les bonnes valeurs en bdd
    public static function getInstance(string $value): State {
        return match (ucfirst($value)) {
            self::Draft->name => State::Draft,
            self::Published->name => State::Published,
            self::Hidden->name => State::Hidden,
            self::Invisible->name => State::Invisible,
        };
    }
}
