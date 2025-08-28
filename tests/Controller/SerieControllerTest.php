<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SerieControllerTest extends WebTestCase
{
    public function testSeriesList(): void
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/TV-show');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'List of TV Shows');
    }

    public function testAddSerieIsWorkingIfUserIsNotLogged(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/TV-show/add');

        $this->assertResponseRedirects('/login', 302);
    }

    public function testAddSerieIsWorkingIfUserIsLogged(){

        $client = static::createClient();

        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => 'sly@mail.com']);
        $client->loginUser($user);

        $crawler = $client->request('GET', '/TV-show/add');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Add a TV Show');
    }

    public function testCreateAccount(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $client->submitForm('Register', [
            'registration_form[email]' => 'toto@mail.com',
            'registration_form[plainPassword]' => '123456',
            'registration_form[firstname]' => 'toto',
            'registration_form[lastname]' => 'totoro',
        ]);

        $this->assertResponseRedirects('/TV-show', 302);

    }
}
