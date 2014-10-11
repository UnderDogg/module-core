<?php namespace Cysha\Modules\Core\Helpers\Forms;

use Illuminate\Support\MessageBag;

class FormUnauthorizedException extends \Exception
{
    /**
    * @var MessageBag
    */
    protected $errors;

    /**
     * @param string $message
     * @param MessageBag $errors
    */
    public function __construct($message, MessageBag $errors)
    {
        $this->errors = $errors;
        parent::__construct($message);
    }

    /**
     * Get form validation errors
     *
     * @return MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }

}
