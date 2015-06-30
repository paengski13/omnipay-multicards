<?php
/**
 * MultiCards REST Purchase Request
 */

namespace Omnipay\MultiCards\Message;

/**
 * MultiCards REST Purchase Request using the Order API
 *
 * Route: https://secure.multicards.com/cgi-bin/order2/poauto3.pl
 *
 * Method: POST
 *
 * ### Examples
 *
 * #### Set Up and Initialise Gateway
 *
 * <code>
 *   // Create a gateway for the MultiCards REST Gateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Omnipay::create('MultiCards');
 *
 *   // Initialise the gateway
 *   $gateway->initialize(array(
 *       'siteKey'      => '1234asdf1234asdf',
 *       'testMode'     => true, // Or false when you are ready for live transactions
 *   ));
 * </code>
 *
 * #### Payment with Card Details
 *
 * <code>
 *   // Create a credit card object
 *   // This card can be used for testing.
 *   $card = new CreditCard(array(
 *               'firstName'             => 'Example',
 *               'lastName'              => 'Customer',
 *               'number'                => '4242424242424242',
 *               'expiryMonth'           => '01',
 *               'expiryYear'            => '2020',
 *               'cvv'                   => '123',
 *               'email'                 => 'customer@example.com',
 *               'billingAddress1'       => '1 Scrubby Creek Road',
 *               'billingCountry'        => 'AU',
 *               'billingCity'           => 'Scrubby Creek',
 *               'billingPostcode'       => '4999',
 *               'billingState'          => 'QLD',
 *               'billingPhone'          => '12341234',
 *   ));
 *
 *   // Do a purchase transaction on the gateway
 *   $transaction = $gateway->purchase(array(
 *       'clientIp'                  => '127.0.0.1',
 *       'amount'                    => '10.00',
 *       'currency'                  => 'AUD',
 *       'description'               => 'Super Deluxe Excellent Discount Package',
 *       'card'                      => $card,
 *   ));
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *       echo "Purchase transaction was successful!\n";
 *       $sale_id = $response->getTransactionReference();
 *       echo "Transaction reference = " . $sale_id . "\n";
 *   }
 * </code>
 *
 * #### Payment with Card Token
 *
 * Card tokens are not supported in MultiCards.
 *
 * ### Parameters
 *
 * * clientIp          [required] - ip address of the user making a payment
 * * amount            [required] -
 * * currency          [required] - ISO 4217 to charge in
 * * description       [required] - description of the purchase
 *
 * #### For credit card payments
 *
 * * card              [required] - Credit card details as an Omnipay CreditCard object
 *
 * #### For credit card token payments
 *
 * Card token payments are not supported.
 *
 * #### For redirect payments
 *
 * These are not yet supported by this gateway plugin.
 *
 * * returnUrl         [required] - URL that the customer is sent to to notify of a successful payment
 * * cancelUrl         [required] - URL that the customer is sent to to notify of a failed payment
 * * billingCountry    [required]
 * * email             [required]
 * * billingPhone      [required]
 *
 * ### Test Payments
 *
 * Once you are logged in, in the merchant menu go to the desktop screen
 * and click on "Test order page". Enable a test credit card code and
 * follow the instructions to run a test order with a test credit card.
 *
 * Make sure that you post your own IP address in the client_ip variable,
 * and that your IP is white listed in the test code.
 *
 * Test card codes expire 60 minutes after being enabled.
 *
 * @see Omnipay\MultiCards\Gateway
 */
class PurchaseRequest extends AbstractRestRequest
{

    /**
     * getData
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        // An amount parameter is required, as is a currency.
        $this->validate('amount', 'currency', 'description');
        $data = parent::getData();
        $data['item_1_desc']  = $this->getDescription();
        $data['item_1_price'] = $this->getAmount();
        $data['item_1_qty']   = 1;
        $data['valuta_code']  = $this->getCurrency();

        $this->validate('card');
        $card = $this->getCard();
        $card->validate();
        $data['cust_name']          = $card->getName();
        $data['cust_address1']      = $card->getBillingAddress1();
        $data['cust_city']          = $card->getBillingCity();
        $data['cust_state']         = $card->getBillingState();
        $data['cust_zip']           = $card->getBillingPostcode();
        $data['cust_phone']         = $card->getBillingPhone();
        $data['cust_email']         = $card->getEmail();
        $data['cust_country']       = $card->getBillingCountry();

        $data['card_num']           = $card->getNumber();
        $data['card_name']          = $card->getName();
        $data['card_exp']           = $card->getExpiryDate('m/y');
        $data['card_code']          = $card->getCvv();

        return $data;
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
        return parent::getEndpoint() . 'order2/poauto3.pl';
    }
}
