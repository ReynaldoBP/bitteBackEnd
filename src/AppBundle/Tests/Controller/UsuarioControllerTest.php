<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsuarioControllerTest extends WebTestCase
{
    public function testGetusuario()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getUsuario');
    }

}
