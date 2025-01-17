<?php

namespace Predis\Command\Traits;

/**
 * Handles last argument passed into command as WITHSCORES
 */
trait WithScores
{
    public function setArguments(array $arguments)
    {
        $withScores = array_pop($arguments);

        if (is_bool($withScores) && $withScores) {
            $arguments[] = 'WITHSCORES';
        } else if (!is_bool($withScores)) {
            $arguments[] = $withScores;
        }

        parent::setArguments($arguments);
    }

    /**
     * Checks for the presence of the WITHSCORES modifier.
     *
     * @return bool
     */
    private function isWithScoreModifier(): bool
    {
        $arguments = parent::getArguments();
        $lastArgument = $arguments[count($arguments) - 1];

        return is_string($lastArgument) && strtoupper($lastArgument) === 'WITHSCORES';
    }

    public function parseResponse($data)
    {
        if ($this->isWithScoreModifier()) {
            $result = [];

            for ($i = 0, $iMax = count($data); $i < $iMax; ++$i) {
                if ($data[$i + 1] ?? false) {
                    $result[$data[$i]] = $data[++$i];
                }
            }

            return $result;
        }

        return $data;
    }
}
