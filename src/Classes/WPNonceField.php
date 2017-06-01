<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Classes;

use Gmosso\WPNonce\Interfaces\WPNonceGetterInterface;
use Gmosso\WPNonce\Interfaces\WPNonceInterface;

/**
 * Class that implements a form field/fields containing a nonce.
 *
 * This class allows getting one or two hidden form fields containing a nonce.
 * Since the relationship between the form field(s) and the nonce is 'has-a'
 * (a form field has a nonce), the relationship between this class and the
 * WPNonce class is represented through composition instead of inheritance.
 * So a WPNonceField contains an instance of a WPNonce (raw nonce).
 * This class implements the functionality of the following WordPress functions:
 * wp_nonce_field().
 *
 * Usage:
 * first a raw nonce must be created and after the corresponding nonce
 * field can be obtained.
 * $nonce = new WPNonce('my_action');
 * $nonce_field = new WPNonceField($nonce, 'wp_nonce', false, false);
 * $nonce_field_html_markup = $nonce_field->get();
 */
class WPNonceField implements WPNonceGetterInterface
{
    /** @var WPNonceInterface the nonce object */
    protected $nonce;
    /** @var string the name of the nonce field */
    protected $name;
    /** @var bool Whether to set the referer field for validation */
    protected $referer;
    /** @var bool Whether to display or return hidden form field */
    protected $echo;
    
    /**
     * Class constructor.
     *
     * @param WPNonceInterface  $nonce   Raw nonce object to embed in the field.
     * @param string            $name    Optional. Nonce name. Default '_wpnonce'.
     * @param bool              $referer Optional. Whether to set the referer field for validation. Default true.
     * @param bool              $echo    Optional. Whether to display or return hidden form field. Default true.
     */
    public function __construct(
        WPNonceInterface $nonce,
        string $name = "_wpnonce",
        bool $referer = true,
        bool $echo = true
    ) {
        $this->nonce = $nonce;
        $this->name = $name;
        $this->referer = $referer;
        $this->echo = $echo;
    }
    
    /**
     * Calculates and returns the nonce field(s) markup.
     *
     * This method is the equivalent of the wp_nonce_field() WordPress function.
     *
     * @return string the nonce field(s) html markup
     */
    public function get(): string
    {
        $nonce_field = $this->name;
        
        $nonce_field .= '|' . $this->nonce->get();
        
        if ($this->referer) {
            $nonce_field .= "|referer";
        }
        
        if ($this->echo) {
            echo $nonce_field;
        }
                
        return $nonce_field;
    }
}
