<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Interfaces;

/**
 * Interface for nonce complete functionality.
 *
 * This interface must be implemented by the class that implements the complete
 * nonce functionality. It contains all methods to manage a nonce. The get
 * method is inherited from WPNonceGetterInterface.
 */
interface WPNonceInterface extends WPNonceGetterInterface
{
    /**
     * Method for managing the "are you sure" case.
     */
    public function ays(): void;
    
    /**
     * Method to verify a nonce.
     *
     * @param   string  $nonce_string_to_verify the nonce to verify
     * @return  bool    true if the nonce is valid, false otherwise
     */
    public function verify(string $nonce_string_to_verify): bool;
}
