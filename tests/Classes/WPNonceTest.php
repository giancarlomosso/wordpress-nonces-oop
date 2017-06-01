<?php
declare(strict_types=1);

namespace Gmosso\WPNonce\Test\Classes;

use PHPUnit\Framework\TestCase;
use Gmosso\WPNonce\Classes\WPNonce;
use Gmosso\WPNonce\Test\Utils\Algorithms;

class WPNonceTest extends TestCase
{
    protected $nonce;
    const ACTION_NAME = 'action1';
    
    public function setUp()
    {
        $this->nonce = new WPNonce(self::ACTION_NAME);
    }
    
    public function testGetOK()
    {
        $nonce_string = $this->nonce->get();
        $expected = Algorithms::rawAlgo(self::ACTION_NAME);
        
        $this->assertEquals($expected, $nonce_string);
    }

    public function testGetFail()
    {
        $nonce_string = $this->nonce->get();
        $expected = 'a' . Algorithms::rawAlgo(self::ACTION_NAME);
        
        $this->assertNotEquals($expected, $nonce_string);
    }
    
    public function testVerifyOK()
    {
        $nonce_to_verify_ok = Algorithms::rawAlgo(self::ACTION_NAME);
        $this->assertTrue($this->nonce->verify($nonce_to_verify_ok));
    }

    public function testVerifyFail()
    {
        $nonce_to_verify_fail = 'a' . Algorithms::rawAlgo(self::ACTION_NAME);
        $this->assertFalse($this->nonce->verify($nonce_to_verify_fail));
    }
    
    public function tearDown()
    {
        unset($this->nonce);
    }
}
