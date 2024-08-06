<?php

namespace ZxcvbnPhp\Matchers;

interface MatchInterface
{
    /**
     * Match this password.
     *
     * @param string $password   Password to check for match
     * @param array  $userInputs Array of values related to the user (optional)
     * @code array('Alice Smith')
     * @endcode
     *
     * @return array Array of Match objects
     */
    public static function doMatch($password, array $userInputs = []): array;

    /**
     * @return int
     */
    public function getGuesses();

    /**
     * @return float
     */
    public function getGuessesLog10();
}
