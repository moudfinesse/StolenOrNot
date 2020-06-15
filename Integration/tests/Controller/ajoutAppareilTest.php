<?php
namespace Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class ajoutAppareilTest extends WebTestCase
{    
    /**
     * ajoutAppareilTest
     *
     * @return void
     */
    public function ajoutAppareilTest()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ajoutappareil');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['type'] = 'Mobile';
        $form['modele'] = 'Plat de pâtes';
        $form['capacite]'] = '600 GB';
        $form['imei]'] = '600 GB';
        $form['mac]'] = '600 GB';
        $form['description]'] = '600 GB';
        $form['status]'] = '600 GB';
        $form['technicals]'] = '600 GB';
        $crawler = $client->submit($form);

        echo $client->getResponse()->getContent();
    }
}