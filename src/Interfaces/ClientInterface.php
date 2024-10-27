<?php

namespace Ay4t\RestClient\Interfaces;

interface ClientInterface
{
    /**
     * @param string $command
     * @param array $params
     * @param string $method
     * @return mixed
     */
    public function cmd(string $method = 'GET', string $command, array $params = []);
}
