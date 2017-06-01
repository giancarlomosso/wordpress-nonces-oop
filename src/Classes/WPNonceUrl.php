<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Classes;

use Gmosso\WPNonce\Interfaces\WPNonceGetterInterface;
use Gmosso\WPNonce\Interfaces\WPNonceInterface;

/**
 * Class that implements a url containing a nonce.
 *
 * This class allows adding a given url a nonce value.
 * Since the relationship between the url and the nonce is 'has-a'
 * (a url has a nonce), the relationship between this class and the
 * WPNonce class is represented through composition instead of inheritance.
 * So a WPNonceUrl contains an instance of a WPNonce (raw nonce).
 * This class implements the functionality of the following WordPress functions:
 * wp_nonce_url().
 *
 * Usage:
 * first a raw nonce must be created and after the corresponding nonce
 * url can be obtained.
 * $nonce = new WPNonce('my_action');
 * $nonce_url = new WPNonceUrl($nonce, 'http://example.com/insertdata', 'wp_nonce');
 * $nonce_url_string = $nonce_url->get();
 */
class WPNonceUrl implements WPNonceGetterInterface
{
    /** @var WPNonceInterface the nonce object */
    protected $nonce;
    /** @var string the name of the nonce field in the url */
    protected $name;
    /** @var string URL to add nonce action */
    protected $action_url;
    
    /**
     * Class constructor.
     *
     * @param WPNonceInterface  $nonce      Raw nonce object to embed in the url.
     * @param string            $action_url URL to add nonce action.
     * @param string            $name       Optional. Nonce name. Default '_wpnonce'.
     */
    public function __construct(
        WPNonceInterface $nonce,
        string $action_url,
        string $name = "_wpnonce"
    ) {
        $this->nonce = $nonce;
        $this->name = $name;
        $this->action_url = $action_url;
    }
    
    /**
     * Calculates and returns the url with the nonce added.
     *
     * This method is the equivalent of the wp_nonce_url() WordPress function.
     *
     * @return string the url with the nonce added
     */
    public function get(): string
    {
        $action_url = str_replace( '&amp;', '&', $this->action_url );
        $nonce_value = $this->nonce->get();

        return "$action_url?{$this->name}=$nonce_value";
    }
}
