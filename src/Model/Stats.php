<?php

namespace App\Model;

/**
 * Class Stats
 * @package App\Model
 */
class Stats
{
    /**
     * @var
     */
    private $statsData;

    /**
     * Stats constructor.
     * @param $statsData
     */
    public function __construct($statsData)
    {
        $this->statsData = $statsData;
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return array_column($this->statsData, 'name');
    }

    /**
     * @return array
     */
    public function getSets()
    {
        return array_column($this->statsData, 'avg_answer');
    }
}