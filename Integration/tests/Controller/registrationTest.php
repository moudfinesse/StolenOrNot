<?php
namespace Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class registrationTest extends WebTestCase
{
    public function registrationTest()
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');
        
        echo $client->getResponse()->getStatusCode();
    }
}