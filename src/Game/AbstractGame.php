<?php

    namespace PickASpy\Game;

    abstract class AbstractGame
    {
        abstract public function getMessages();

        public $successMessage = 'Messages Sent';
        protected $playerCount = null;

        public function __construct($count)
        {
            $this->playerCount = $count;
        }

        protected function random_from($arr)
        {
            return $arr[mt_rand(0, count($arr) - 1)];
        }

        protected function random_key($arr)
        {
            return $this->random_from(array_keys($arr));
        }
    }
