<?php

namespace App\GraphQL\Error;

use GraphQL\Error\Error;
use Rebing\GraphQL\Error\ValidationError;
use Rebing\GraphQL\GraphQL;

class CustomErrorGraphQL extends GraphQL
{
    public static function formatError(Error $e)
    {
        $message = $e->getMessage();
        $code = $e->getCode() !== 0 ? $e->getCode() : 400;

        $previous = $e->getPrevious();

        $error = new \stdClass();
        $error->message = $message;
        $error->statusCode = $code;

        if ($previous && $previous instanceof ValidationError) {
            $error->validation = $previous->getValidatorMessages();
        }

        return $error;
    }
}