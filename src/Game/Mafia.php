<?php

    namespace PickASpy\Game;

    /**
     * Two mafiosas
     */
    class Mafia extends BasicGame
    {
        public $successMessage = 'Mafiosas Chosen';

        protected $innocentRoles = [
            'a Bystander',
            'a Citizen',
            'a Townsfolk',
            'a Villager',
            'unsuspecting and unawares',
        ];

        public function __construct($count)
        {
            parent::__construct($count);

            $this->specialRoles = ['in the Mafia'];
            if ($count >= 4) {
                $this->specialRoles[] = 'in the Mafia';
            }
            if ($count >= 5) {
                $this->specialRoles[] = 'the Doctor';
                $this->specialRoles[] = mt_rand(1, 10) === 5
                    ? "BATMAN!!! Which is the same as being the Sheriff, except, of course, you're Batman"
                    : 'the Sheriff';
            }
        }
    }
