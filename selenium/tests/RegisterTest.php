<?php

require __DIR__ . '/../../vendor/autoload.php';

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class RegitsterTest extends PHPUnit_Framework_TestCase
{

    protected $webDriver;

    public function setUp()
    {
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', DesiredCapabilities::firefox());
    }

    public function tearDown()
    {
        $this->webDriver->quit();
    }

    public function testFillFormAndSubmit()
    {
        $this->webDriver->get('http://localhost:8080/selenium/register.html');
        $form = $this->webDriver->findElement(WebDriverBy::id('register-form'));

        $form->findElement(WebDriverBy::name('first_name'))->sendKeys('Dino');
        $form->findElement(WebDriverBy::name('last_name'))->sendKeys('Lai');

        $form->submit();

        $content = $this->webDriver->findElement(WebDriverBy::tagName('body'))->getText();
        $this->assertEquals('Dino Lai', $content);
    }
}