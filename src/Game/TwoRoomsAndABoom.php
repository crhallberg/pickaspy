<?php

    namespace PickASpy\Game;

    /**
     * Two mafiosas
     */
    class TwoRoomsAndABoom extends BasicGame
    {
        public $successMessage = 'Government "Elected"';

        public function __construct($count)
        {
            parent::__construct($count);

            $divider = "\n\n\nScroll to hide your role\n\n\n";

            $this->specialRoles = [
                'Blue Team' . $divider . 'You are the President',
                'Red Team' . $divider . 'You are the Bomber'
            ];
            $red = 'Red Team' . $divider . 'Normal Fighter';
            $blue = 'Blue Team' . $divider . 'Citizen';

            $start = 2;
            if ($count % 2 === 1) {
                $this->specialRoles[] = $this->random_from([$red, $blue]);
                $start = 3;
            }

            for ($i = $start; $i < $count; $i += 2) {
                $this->specialRoles[] = $red;
                $this->specialRoles[] = $blue;
            }
        }

        public function getMessages()
        {
            shuffle($this->specialRoles);
            return $this->specialRoles;
        }
    }
