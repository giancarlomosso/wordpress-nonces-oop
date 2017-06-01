<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Test\Classes;

use PHPUnit\Framework\TestCase;
use Gmosso\WPNonce\Classes\WPNonce;
use Gmosso\WPNonce\Classes\WPNonceUrl;
use Gmosso\WPNonce\Test\Utils\Algorithms;

class WPNonceUrlTest extends TestCase
{
    protected $nonce;
    const ACTION_NAME = -1;
    const EXAMPLE_ACTION_URL = 'http://example.com/insertvalue';
    
    public function setUp()
    {
        $this->nonce = new WPNonce(self::ACTION_NAME);
    }
    
    public function testGet()
    {
        $nonce_field = new WPNonceUrl($this->nonce, self::EXAMPLE_ACTION_URL, 'my_nonce');
        $expected = Algorithms::urlAlgo($this->nonce, self::EXAMPLE_ACTION_URL, 'my_nonce');
        
        $this->assertEquals($expected, $nonce_field->get());
    }

    public function testGetDifferentName()
    {
        $nonce_field = new WPNonceUrl($this->nonce, self::EXAMPLE_ACTION_URL, 'my_nonce');
        $expected = Algorithms::urlAlgo($this->nonce, self::EXAMPLE_ACTION_URL, 'my_nonce_different');
        
        $this->assertNotEquals($expected, $nonce_field->get());
    }

    public function testGetDifferentActionUrl()
    {
        $nonce_field = new WPNonceUrl($this->nonce, self::EXAMPLE_ACTION_URL, 'my_nonce');
        $expected = Algorithms::urlAlgo($this->nonce, self::EXAMPLE_ACTION_URL . 'a', 'my_nonce_different');
        
        $this->assertNotEquals($expected, $nonce_field->get());
    }
    
    public function tearDown()
    {
        unset($this->nonce);
    }
}
