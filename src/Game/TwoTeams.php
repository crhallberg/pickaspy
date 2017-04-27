<?php

    namespace PickASpy\Game;

    class TwoTeams extends BasicGame
    {
        public $successMessage = 'Teams Formed';

        public function __construct($count)
        {
            parent::__construct($count);

            $this->specialRoles = [];
            list($one, $two) = $this->random_from([
                ['on Red Team', 'on Blue Team'],
                ['on Team 1', 'on Team 2'],
                ['a Carnivore', 'an Herbivore'],
                ['a Wizard', 'a Muggle'],
                ['Team Edward', 'Team Jacob'],
                ['a Chocolate-Lover', 'a Vanilla-Purist'],
                ['from Beyond the Wall', 'from the Realms of Men'],
                ['Team Nerd', 'Team Geek'],
                ['an Angel', 'a Demon'],
                ['a Mac', 'a PC'],
            ]);
            for ($i = 0; $i < floor($count / 2); $i++) {
                $this->specialRoles[] = $one;
                $this->specialRoles[] = $two;
            }
            if ($count % 2 === 1) {
                $this->specialRoles[] = $this->random_from([$one, $two]);
            }
        }
    }