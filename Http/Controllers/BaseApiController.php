<?php namespace Cms\Modules\Core\Http\Controllers;

use Illuminate\Support\Facades\Response;
// use Dingo\Api\Http\ResponseFactory;

class BaseApiController extends BaseController
{
    //use \Dingo\Api\Routing\ControllerTrait;

    public function boot()
    {
        // parent::boot();

        // $this->setResponseFactory(app('Dingo\Api\Http\ResponseFactory'));
    }

    /**
     * Alias method for sending an response back
     *
     * @param string  $message
     * @param integer $status  HTTP Status Code
     */
    public function sendResponse($message = 'ok', $status = 200, $data = [])
    {
        $reply = [
            'message'     => $message,
            'status_code' => $status,
        ];

        if (!empty($data)) {
            $reply['data'] = $data;
        }

        //return $this->response->array($reply)->setStatusCode($status);
        return response()->json($reply, $status);
    }

    /**
     * Alias method for sending an error status back
     *
     * @param string  $message
     * @param integer $status  HTTP Status Code
     */
    public function sendError($message, $status = 500)
    {
        return $this->sendResponse($message, $status);
    }

    /**
     * Alias method for sending an ok status back
     *
     * @param string  $message
     * @param integer $status  HTTP Status Code
     */
    public function sendOK($message, $status = 200)
    {
        return $this->sendResponse($message, $status);
    }

    /**
     * On missing method, throw an error
     *
     * @param array $parameters
     */
    public function missingMethod($parameters = [])
    {
        return $this->sendError('Invalid Method');
    }
}
