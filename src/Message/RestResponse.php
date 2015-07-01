<?php
/**
 * MultiCards REST Response
 */

namespace Omnipay\Multicards\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * MultiCards REST Response
 *
 * This is the response class for all MultiCards REST requests.
 *
 * @see \Omnipay\Multicards\Gateway
 */
class RestResponse extends AbstractResponse
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    public function isSuccessful()
    {
        // The MultiCards gateway returns errors in several possible different ways.
        if ($this->getCode() >= 400) {
            return false;
        }
        
        if (! empty($this->data['error'])) {
            return false;
        }
        
        if (! empty($this->data['response_code']) && $this->data['response_code'] > 1) {
            return false;
        }
        
        return true;
    }

    public function getTransactionReference()
    {
        // This is usually correct for payments, authorizations, etc
        if (! empty($this->data['trans_id'])) {
            return $this->data['trans_id'];
        }
        if (! empty($this->data['order_num'])) {
            return $this->data['order_num'];
        }

        return null;
    }

    public function getMessage()
    {
        if (isset($this->data['error'])) {
            return $this->data['error'];
        }
        return null;
    }

    public function getCode()
    {
        return $this->statusCode;
    }
}
