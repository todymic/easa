<?php

use Behat\Behat\Context\Context;

class SecurityContext implements Context
{
    /**
     * @Given /^I want to log in$/
     */
    public function iWantToLogIn()
    {
        throw new \Behat\Behat\Tester\Exception\PendingException();
    }
}
