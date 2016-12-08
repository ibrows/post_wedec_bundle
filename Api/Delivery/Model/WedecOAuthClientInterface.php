<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\Model;


interface WedecOAuthClientInterface
{
    // calculate delivery expenses depending on the date
    const SCOPE_DELIVERY    = 'WEDEC_DELIVERY';
    // ?? API Documentation inconsistency?!
    const SCOPE_READ_DELIVERY_READ = 'WEDEC_READ_DELIVERY';

    // get suggestions of SwissPost's known addresses while typing
    const SCOPE_AUTOCOMPLETE_ADDRESS = 'WEDEC_AUTOCOMPLETE_ADDRESS';
    // to read user addresses
    const SCOPE_READ_ADDRESS = 'WEDEC_READ_ADDRESS';
    // to read only the user main addresses
    const SCOPE_READ_MAIN_ADDRESS = 'WEDEC_READ_MAIN_ADDRESS';
    // to validate an address according SwissPost ruless
    const SCOPE_VALIDATE_ADDRESS = 'WEDEC_VALIDATE_ADDRESS';

    /**
     * @return string
     */
    public function getClientId();

    /**
     * @return string
     */
    public function getClientSecret();
}