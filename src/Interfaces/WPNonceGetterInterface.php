<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Interfaces;

/**
 * Interface for getting the nonce.
 *
 * This interface must be implemented by all classes that provide a nonce in
 * any form: raw or embedded.
 */
interface WPNonceGetterInterface
{
    /**
     * Method to get the nonce value.
     *
     * This method returns the nonce based on the provided parameters and
     * timestamp.
     *
     * @return string the nonce value (raw or embedded)
     */
    public function get(): string;
}
