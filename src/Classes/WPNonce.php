<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Classes;

use Gmosso\WPNonce\Interfaces\WPNonceInterface;

/**
 * Class that implements the WordPress nonce algorithms.
 *
 * It implements the whole functionality of a WordPress nonce value:
 * creating it, getting it, verifying, managing the "are you sure ?" case.
 * It manages the raw nonce, i.e. it does not return the nonce value embedded
 * in form fields or in a url: for this functionality please see the classes
 * WPNonceField and WPNonceUrl.
 * This class implements the functionality of the following WordPress functions:
 * wp_create_nonce(), wp_verify_nonce(), wp_nonce_ays().
 *
 * Usage:
 * - get a nonce:
 *     $nonce = new WPNonce('my_action');
 *     $nonce_string = $nonce->get();
 * - verify a nonce:
 *     if the received nonce is 'abcd123456' and the
 *     action is 'my_action'
 *     $nonce = new WPNonce('my_action');
 *     $nonce_OK = $nonce->verify('abcd123456');
 * - manage the "are you sure ?" case:
 *     $nonce = new WPNonce('my_action');
 *     $nonce->ays();
 */
class WPNonce implements WPNonceInterface
{
    /** @var string the nonce calculated value */
    protected $nonce_string;
    /** @var string|int the action the nonce is created for */
    protected $action;
    /** constant string to create stubbed nonce value */
    const STUBBED_NONCE_STRING = 'raw_nonce_for_action_';
    
    /**
     * Class constructor.
     *
     * @param string|int $action Optional. The action the nonce is created for
     */
    public function __construct($action = -1)
    {
        $this->action = $action;
        $this->nonce_string = '';
    }
    
    /**
     * Calculates the nonce value and stores it in the class.
     *
     * @return string the nonce calculated value
     */
    protected function create(): string
    {
        $this->nonce_string = self::STUBBED_NONCE_STRING . (string)$this->action;
        return $this->nonce_string;
    }
    
    /**
     * Outputs the "Are you sure ?" string and terminates script execution.
     *
     * This method is the equivalent of the wp_nonce_ays() WordPress function.
     */
    public function ays(): void
    {
        die("Are you sure ?");
    }
    
    /**
     * Calculates and returns the raw nonce value.
     *
     * This method is the equivalent of the wp_create_nonce() WordPress function.
     *
     * @return string the nonce calculated value
     */
    public function get(): string
    {
        return $this->create();
    }
    
    /**
     * Verifies a nonce.
     *
     * This method verifies if the nonce string passed as parameter matches
     * the nonce represented by the current object.
     * It is the equivalent of the wp_verify_nonce() WordPress function.
     *
     * @param   string  $nonce_string_to_verify the nonce to verify
     * @return  bool    true if the nonce is valid, false otherwise
     */
    public function verify(string $nonce_string_to_verify): bool
    {
        $expected = $this->create();
        return ($expected === $nonce_string_to_verify);
    }
}
