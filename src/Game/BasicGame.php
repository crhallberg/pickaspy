<?php

    namespace PickASpy\Game;

    class BasicGame extends AbstractGame
    {
        public $successMessage = 'Traitor Turned';
        protected $specialRoles = ['the Spy'];
        protected $innocentRoles = ['a Bystander'];

        protected function addSpice($msg)
        {
            if (mt_rand(0, 100) > 10) {
                return $msg . $this->random_from([
                    ". Good luck!",
                    ". Have fun!",
                    ". Go get 'em.",
                ]);
            } else {
                return $msg . $this->random_from([
                    "... I... I'm sure you'll be fine.",
                    "... but pretend you're not?",
                    ". You are also in love with the person to your right.",
                    " and you're *quite* drunk.",
                    ". Yes, again. Look. I'm doing the best I can.",
                    ". Call me. ;)",
                    ".\n\nLove,\nYour Secret Admirer <3",
                    " and your super power is stunning hair. Like, seriously. WOW.",
                ]);
            }
        }

        public function getMessages()
        {
            $roles = [];
            for ($i = 0; $i < count($this->specialRoles) && $i < $this->playerCount; $i++) {
                $roles[] = $this->addSpice('You are ' . $this->specialRoles[$i]);
            }
            for ($i = count($this->specialRoles); $i < $this->playerCount; $i++) {
                $roles[] = $this->addSpice('You are ' . $this->random_from($this->innocentRoles));
            }
            shuffle($roles);
            return $roles;
        }
    }
