<?php

    namespace PickASpy\Game;

    class Tournament extends NumOrder
    {
        public $successMessage = 'Tourney Arranged';

        public function __construct($count)
        {
            parent::__construct($count);

            $roles = [];
            if (mt_rand(1, 10) >= 5) {
                $roles = array_map(
                    function($op) { return 'Number ' . $op; },
                    array_slice($this->cardinal, 0, $count)
                );
            } else {
                $roles = [];
                for ($i = 0; $i < $count; $i++) {
                    $roles[] = 'Number #' . ($i + 1);
                }
            }
            // Arrange tourney
            $turns = [];
            // - Largest lesser power of two
            $two = 2;
            while ($two < $count) {
                $two *= 2;
            }
            $two /= 2;
            // - For each step over a power of two, arrange a two-step entry
            $index = 0;
            $diff = $count - $two;
            while ($diff > 0) {
                $turns[] = $roles[$index + 1];
                $turns[] = $roles[$index];
                $turns[] = 'the Winner of ' . $roles[$index] . ' vs ' . $roles[$index + 1];
                $index += 3;
                $diff --;
            }
            while ($index < $count) {
                $turns[] = $roles[$index + 1];
                $turns[] = $roles[$index];
                $index += 2;
            }
            // Assign
            $this->specialRoles = [];
            for ($i = 0; $i < $count; $i++) {
                $this->specialRoles[] = $roles[$i] . arr_random([
                    '. You will be facing ',
                    '. Your opponent is ',
                    ". You'll start by facing ",
                    ". It's fallen on you to teach a lesson to ",
                ]) . $turns[$i];
            }
        }
    }
