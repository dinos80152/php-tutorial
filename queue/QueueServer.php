<?php

set_time_limit(0);

class QueueServer
{
    protected $host;
    protected $port;
    protected $sock;
    protected $queue;
    protected $msgSock;

    public function __construct($host, $port)
    {
        $this->queue = new Queue;
        $this->host = $host;
        $this->port = $port;
    }

    public function start()
    {

    }

    protected function create()
    {
        $this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if ($sock === false) {
            throw new Excpetion("socket_create() failed: reason: " . socket_strerror(socket_last_error()));
        }
    }

    protected function bind()
    {
        if (socket_bind($this->sock, $this->host, $this->port) === false) {
            throw new Excpetion("socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)));
        }
    }

    protected function listen()
    {
        if (socket_listen($this->sock, 5) === false) {
            throw new Excpetion("socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)));
        }
    }

    protected function accept()
    {
        if (($this->msgsock = socket_accept($this->sock)) === false) {
            throw new Excpetion( "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)));
        }

        /* Send instructions. */
        $message = "Welcome to the PHP Test Queue Server.";
        $this->write($message);
    }

    protected function read()
    {
        if (false === ($buffer = socket_read($this->msgsock, 2048, PHP_NORMAL_READ))) {
            throw new Exception("socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)));
        }

        if ($buffer === 'Set') {
            $this->queue->enqueue($buffer);
            $message = "Add A Message Into Queue Success!!";
            $this->write($message);
        }

        if ($buffer === 'Get') {
            $message = $this->queue->dequeue();
            $this->write($message);
        }

    }

    protected function write($message)
    {
        socket_write($this->msgSock, $message, strlen($message));
    }
}