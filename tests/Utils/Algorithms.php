<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Test\Utils;

use Gmosso\WPNonce\Interfaces\WPNonceInterface;
use Gmosso\WPNonce\Classes\WPNonce;

/**
 * Utility class for the nonce algorithms.
 *
 * This class contains the algorithms used to generate the raw nonce, a nonce
 * embedded in hidden field(s) and a nonce in a url. These algorithms are written
 * separately from the src code algorithms to allow testing the src code.
 */
class Algorithms
{
    public static function rawAlgo($action): string
    {
        return WPNonce::STUBBED_NONCE_STRING . (string)$action;
    }
    
    public static function fieldAlgo(
        WPNonceInterface $nonce,
        string $name,
        bool $referer,
        bool $echo
    ): string {
        $nonce_field = $name;
        
        $nonce_field .= '|' . $nonce->get();
        
        if ($referer) {
            $nonce_field .= "|referer";
        }
        
        if ($echo) {
            echo $nonce_field;
        }
                
        return $nonce_field;
    }
    
    public static function urlAlgo(
        WPNonceInterface $nonce,
        string $action_url,
        string $name
    ): string {
        $action_url = str_replace( '&amp;', '&', $action_url );
        $nonce_value = $nonce->get();

        return "$action_url?$name=$nonce_value";
    }
}
