<?php
/**
 * MultiCards REST Complete Purchase Request
 */

namespace Omnipay\Multicards\Message;

/**
 * MultiCards REST Complete Purchase Request for 3d-Secure
 *
 * Route: https://secure.multicards.com/cgi-bin/order2/poauto3d.pl
 *
 * Method: POST
 */
// @TODO: I cannot figure out yet what to call after ACS send the data back to the site. So for now let's just use completePurchaseRequest
class CompletePurchaseRequest extends AbstractRestRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['response']                       = $this->getResponse();
        $data['threedsecure_verificationpath']  = $this->getThreedsecureVerificationpath();
        $data['PO3SessionID']                    = $this->getPO3SessionID();

        return $data;
    }

    /**
     * @TODO: Add doc block
     */
    public function getResponse()
    {
        return $this->getParameter('response');
    }

    /**
     * @TODO: Add doc block
     */
    public function setResponse($value)
    {
        return $this->setParameter('response', $value);
    }

    /**
     * @TODO: Add doc block
     */
    public function getThreedsecureVerificationpath()
    {
        return $this->getParameter('threedsecure_verificationpath');
    }

    /**
     * @TODO: Add doc block
     */
    public function setThreedsecureVerificationpath($value)
    {
        return $this->setParameter('threedsecure_verificationpath', $value);
    }

    /**
     * @TODO: Add doc block
     */
    public function getPO3SessionID()
    {
        return $this->getParameter('PO3SessionID');
    }

    /**
     * @TODO: Add doc block
     */
    public function setPO3SessionID($value)
    {
        return $this->setParameter('PO3SessionID', $value);
    }

    /**
     * Get transaction endpoint.
     *
     * Purchases are created using the /payments/submit resource.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint() . 'order2/poauto3d.pl';
    }
}
