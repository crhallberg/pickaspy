<?php

    namespace PickASpy\Game;

    /**
     * 1/3 of players are werewolves
     */
    class Werewolf extends BasicGame
    {
        public $successMessage = 'The Moon is Rising';

        protected $innocentRoles = [
            'a Bystander',
            'a Citizen',
            'a Townsfolk',
            'a Villager'
        ];

        public function __construct($count)
        {
            parent::__construct($count);

            $this->specialRoles = [];
            $packSize = max(1, round($count / 3));
            for ($i = 0; $i < $packSize; $i++) {
                $this->specialRoles[] = 'a Werewolf';
            }
            if ($count >= 5) {
                $this->specialRoles[] = 'the Seer';
                $this->specialRoles[] = 'the Healer';
            }
        }
    }
