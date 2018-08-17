<?php


namespace Quiz\Tests;


class BowlingCalculator
{
    private $throws= [];

    /**
     * @param int $hits
     */
    public function throw(int $hits)
    {
        $this->throws[] = $hits;
    }

    /**
     * @param int $hits
     * @return int
     */
    public function getScore(): int
    {
        $score = 0;
        $currentThrow = 0;

        for($i = 0 ; $i < 10 ; $i++){
            if ($this->isStrike($currentThrow))
            {
                $score += $this->addStrike($currentThrow);
                $currentThrow +=1;
            }
            elseif ($this->isSpare($currentThrow))
            {
                $score += $this->addSpare($currentThrow);
                $currentThrow +=2;
            }
            else
            {
                $score += $this->addNormal($currentThrow);
                $currentThrow +=2;
            }
        }
        return $score;
    }

    /**
     * @param $currentThrow
     * @return bool
     */
    public function isSpare($currentThrow): bool
    {
        return $this->throws[$currentThrow] + $this->throws[$currentThrow+1] == 10;
    }

    /**
     * @param $currentThrow
     * @return bool
     */
    public function isStrike($currentThrow): bool
    {
        return $this->throws[$currentThrow] == 10;
    }

    /**
     * @param $currentThrow
     * @return mixed
     */
    public function addSpare($currentThrow): int
    {
        return 10 + $this->throws[$currentThrow + 1];
    }

    public function addStrike($currentThrow): int
    {
        return 10 + $this->throws[$currentThrow + 1] + $this->throws[$currentThrow + 2];
    }

    /**
     * @param $currentThrow
     * @return mixed
     */
    public function addNormal($currentThrow): int
    {
        return $this->throws[$currentThrow] + $this->throws[$currentThrow + 1];
    }
}