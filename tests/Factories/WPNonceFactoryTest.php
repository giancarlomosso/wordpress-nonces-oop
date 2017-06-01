<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Test\Classes;

use PHPUnit\Framework\TestCase;
use Gmosso\WPNonce\Classes\WPNonce;
use Gmosso\WPNonce\Classes\WPNonceField;
use Gmosso\WPNonce\Classes\WPNonceUrl;
use Gmosso\WPNonce\Factories\WPNonceFactory;
use Gmosso\WPNonce\Test\Utils\Algorithms;

class WPNonceFactoryTest extends TestCase
{
    protected $nonce;
    protected $nonce_factory;
    const ACTION_NAME = 'action_factory';
    
    public function setUp()
    {
        $this->nonce = new WPNonce(self::ACTION_NAME);
        $this->nonce_factory = new WPNonceFactory(self::ACTION_NAME);
    }
    
    public function testRawType()
    {
        $nonce_raw = $this->nonce_factory->getRaw();
        $this->assertInstanceOf(WPNonce::class, $nonce_raw);
    }

    public function testRawValue()
    {
        $nonce_raw_value = $this->nonce_factory->getRaw()->get();
        $expected = Algorithms::rawAlgo(self::ACTION_NAME);
        
        $this->assertEquals($expected, $nonce_raw_value);
    }

    public function testFieldType()
    {
        $nonce_field = $this->nonce_factory->getField();
        $this->assertInstanceOf(WPNonceField::class, $nonce_field);
    }

    public function testFieldValue()
    {
        $nonce_field_value = $this->nonce_factory->getField('factory_nonce', false, false)->get();
        $expected = Algorithms::fieldAlgo($this->nonce, 'factory_nonce', false, false);
        
        $this->assertEquals($expected, $nonce_field_value);
    }

    public function testUrlType()
    {
        $nonce_url = $this->nonce_factory->getUrl('http://example.org/factories');
        $this->assertInstanceOf(WPNonceUrl::class, $nonce_url);
    }

    public function testUrlValue()
    {
        $nonce_url_value = $this->nonce_factory->getUrl('http://example.org/factories', 'factory_nonce')->get();
        $expected = Algorithms::urlAlgo($this->nonce, 'http://example.org/factories', 'factory_nonce');
        
        $this->assertEquals($expected, $nonce_url_value);
    }
    
    public function tearDown()
    {
        unset($this->nonce_factory);
    }
}
