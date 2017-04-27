<?php

    namespace PickASpy\Game;

    class NumOrder extends BasicGame
    {
        public $successMessage = 'Players Sorted';

        protected $cardinal = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen', 'Twenty', 'Twenty-One', 'Twenty-Two', 'Twenty-Three', 'Twenty-Four', 'Twenty-Five', 'Twenty-Six', 'Twenty-Seven', 'Twenty-Eight', 'Twenty-Nine', 'Thirty'];
        protected $ordinal = ['First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth'];

        public function __construct($count)
        {
            parent::__construct($count);

            $start = $count > count($this->ordinal) ? 2 : 1;
            switch(mt_rand($start, 3)) {
                case 1: {
                    $this->specialRoles = array_slice($this->ordinal, 0, $count);
                    break;
                }
                case 2: {
                    $this->specialRoles = array_map(
                        function($op) { return 'Number ' . $op; },
                        array_slice($this->cardinal, 0, $count)
                    );
                    break;
                }
                default: {
                    $this->specialRoles = [];
                    for ($i = 0; $i < $count; $i++) {
                        $this->specialRoles[] = 'Number #' . ($i + 1);
                    }
                    break;
                }
            }
        }
    }
