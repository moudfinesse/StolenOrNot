<?php
namespace Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class searchTest extends WebTestCase
{
    public function searchTest()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        
        echo $client->getResponse()->getStatusCode();
    }
}