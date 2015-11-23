<?php

class Queue
{
    protected $queue = [];

    public function enqueue($element)
    {
        return array_push($this->queue, $element);
    }

    public function dequeue()
    {
        return array_shift($this->queue);
    }
}