<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Test\Classes;

use PHPUnit\Framework\TestCase;
use Gmosso\WPNonce\Classes\WPNonce;
use Gmosso\WPNonce\Classes\WPNonceField;
use Gmosso\WPNonce\Test\Utils\Algorithms;

class WPNonceFieldTest extends TestCase
{
    protected $nonce;
    const ACTION_NAME = -1;
    
    public function setUp()
    {
        $this->nonce = new WPNonce(self::ACTION_NAME);
    }
    
    public function testGetNoReferer()
    {
        $nonce_field = new WPNonceField($this->nonce, 'my_nonce', false, false);
        $expected = Algorithms::fieldAlgo($this->nonce, 'my_nonce', false, false);
        
        $this->assertEquals($expected, $nonce_field->get());
    }

    public function testGetWithReferer()
    {
        $nonce_field = new WPNonceField($this->nonce, 'my_nonce', true, false);
        $expected = Algorithms::fieldAlgo($this->nonce, 'my_nonce', true, false);
        
        $this->assertEquals($expected, $nonce_field->get());
    }

    public function testGetWithEcho()
    {
        // Create nonce field and make it echo (get return value not used)
        $nonce_field = new WPNonceField($this->nonce, 'my_nonce', false, true);
        $nonce_field->get();
        
        //Calculate expected echo by disabling echo from algorihtm
        $expected = Algorithms::fieldAlgo($this->nonce, 'my_nonce', false, false);
        
        $this->expectOutputString($expected);
    }

    public function testGetWithRefererAndEcho()
    {
        // Create nonce field and make it echo (get return value not used)
        $nonce_field = new WPNonceField($this->nonce, 'my_nonce', true, true);
        $nonce_field->get();
        
        //Calculate expected echo by disabling echo from algorihtm
        $expected = Algorithms::fieldAlgo($this->nonce, 'my_nonce', true, false);
        
        $this->expectOutputString($expected);
    }

    public function testGetDifferentName()
    {
        $nonce_field = new WPNonceField($this->nonce, 'my_nonce', true, false);
        $expected = Algorithms::fieldAlgo($this->nonce, 'my_nonce_different', true, false);
        
        $this->assertNotEquals($expected, $nonce_field->get());
    }

    public function testGetDifferentReferer()
    {
        $nonce_field = new WPNonceField($this->nonce, 'my_nonce', false, false);
        $expected = Algorithms::fieldAlgo($this->nonce, 'my_nonce', true, false);
        
        $this->assertNotEquals($expected, $nonce_field->get());
    }

    public function testGetDifferentNameAndReferer()
    {
        $nonce_field = new WPNonceField($this->nonce, 'my_nonce', false, false);
        $expected = Algorithms::fieldAlgo($this->nonce, 'my_nonce_different', true, false);
        
        $this->assertNotEquals($expected, $nonce_field->get());
    }
    
    public function tearDown()
    {
        unset($this->nonce);
    }
}
