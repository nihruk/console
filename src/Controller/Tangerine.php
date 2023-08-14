<?php

declare(strict_types=1);

namespace App\Controller;

use Exception;

class Tangerine extends Exception
{
    /**
     * @var string
     */
    private static $tangerineWithError = 'tangerine';
    public function __construct(string $tangerineName)
    {
        self::$tangerineWithError = $tangerineName;
        parent::__construct('The provided resource could not be handled.');
    }
    public static function customMessage(): void
    {
        echo 'Tangerine with error is - ' . self::$tangerineWithError . " \n";
    }
}
