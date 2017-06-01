<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Factories;

use Gmosso\WPNonce\Classes\WPNonce;
use Gmosso\WPNonce\Classes\WPNonceField;
use Gmosso\WPNonce\Classes\WPNonceUrl;

/**
 * Factory class to create nonces. This is the class to be used by the client code.
 *
 * This Factory encapsulates the creation algorithms for a raw nonce, hidden
 * field(s) with an embedded nonce and a url with a nonce added.
 *
 * Usage:
 * please see README file.
 */
class WPNonceFactory
{
    /** @var WPNonce the instance of the nonce to use */
    protected $nonce;
    
    /**
     * Class constructor.
     *
     * @param string|int $action Optional. The action the nonce is created for
     */
    public function __construct($action = -1)
    {
        $this->nonce = new WPNonce($action);
    }
    
    /**
     * Method to get a raw nonce.
     *
     * This method returns the raw nonce, i.e. the nonce not embedded in a
     * form field or added to a url.
     *
     * @return WPNonce the instance of the raw nonce
     */
    public function getRaw(): WPNonce
    {
        return $this->nonce;
    }
    
    /**
     * Method to get hidden field(s) with an embedded nonce.
     *
     * @param   string $name    Optional. Nonce name. Default '_wpnonce'.
     * @param   bool $referer   Optional. Whether to set the referer field for validation. Default true.
     * @param   bool $echo      Optional. Whether to display or return hidden form field. Default true.
     * @return  WPNonceField    the instance of the hidden field(s) nonce
     */
    public function getField(
        string $name = "_wpnonce",
        bool $referer = true,
        bool $echo = true
    ): WPNonceField {
        return new WPNonceField($this->nonce, $name, $referer, $echo);
    }

    /**
     * Method to get a url with the nonce added.
     *
     * @param   string $action_url  URL to add nonce action.
     * @param   string $name        Optional. Nonce name. Default '_wpnonce'.
     * @return  WPNonceUrl          the instance of the url nonce
     */
    public function getUrl(string $action_url, string $name = "_wpnonce"): WPNonceUrl
    {
        return new WPNonceUrl($this->nonce, $action_url, $name);
    }
}
