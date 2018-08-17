<?php

namespace Quiz\Database\MySql;

class MysqlConnectionConfig
{
    /** @var string  */
    public $driver = 'mysql';

    /** @var string  */
    public $host = '127.0.0.1';

    /** @var string  */
    public $port = '3306';

    /** @var string  */
    public $user = 'homestead';

    /** @var string  */
    public $password = 'secret';

    /** @var string  */
    public $database = 'quiz';
}