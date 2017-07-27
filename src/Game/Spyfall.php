<?php

    namespace PickASpy\Game;

    class Spyfall extends BasicGame
    {
        public $successMessage = 'Spy Teleported';

        public function __construct($count)
        {
            parent::__construct($count);

            $locations = json_decode($this->get_data('spyfall_locations.json'));
            $keys = [];
            foreach ($locations as $key => $val) {
                $keys[] = $key;
            }

            do {
                $location = $this->random_from($keys);
            } while (isset($_SESSION['spyfall_prev']) && $_SESSION['spyfall_prev'] == $location);
            $_SESSION['spyfall_prev'] = $location;

            $this->specialRoles = ['the Spy! Figure out where you are'];
            $jobs = $locations->$location;
            shuffle($jobs);
            for ($i = 1; $i < $count; $i++) {
                if ($i < count($jobs)) {
                    $this->specialRoles[] = $jobs[$i - 1] . ' ' . $location . '. Figure out who the Spy is';
                } else {
                    $this->specialRoles[] = $location . '. Figure out who the Spy is';
                }
            }
        }
    }
