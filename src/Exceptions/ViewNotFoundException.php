<?php


namespace Quiz\Exceptions;
use Exception;

class ViewNotFoundException extends Exception
{

    /** @var string $message */
    protected $message = 'View not found';

}