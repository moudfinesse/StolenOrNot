<?php
namespace Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class dashboardTest extends WebTestCase
{
    public function testDashboard()
    {
        $client = static::createClient();
        $client->request('GET', '/dashboard');
        
        echo $client->getResponse()->getStatusCode();
    }
}