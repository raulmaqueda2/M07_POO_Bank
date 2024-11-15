<?php
namespace ComBank\Exceptions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 2:20 PM
 */

class FailedCreateAccountException extends BaseExceptions
{
    protected $errorCode = 401;
    protected $errorLabel = 'FailedCreateAccountException';
}
