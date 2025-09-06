<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResgiterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient(); // créer le client

        /* pointer ver une url vers ou on veut faire le test

        et lui passer le bouton ainsi que les champs du formulaire a remplir avec les valeurs prédfinis

        */

        $client->request('GET', '/inscription');
        $client->submitForm('register_user_submit', [

       'register_user[email]' => 'test@example.com',
         'register_user[plainPassword][first]' => '12345',
        'register_user[plainPassword][second]' => '12345',
       'register_user[firstname]' => 'Test',
        'register_user[lastname]' => 'Php'


        ]);


        // suivre la redirection apres validation du formulaire
        $this->assertResponseRedirects('/connexion');
            $client->followRedirect();

        // doit renvoyer le résultat attendu (message flash de confirmation)
        $this->assertSelectorExists('div:contains("Votre compte à bien était crée !")');







        $crawler = $client->request('GET', '/');


    }
}
