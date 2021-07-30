<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Mailer\MailerInterface;
use Zenstruck\Foundry\Test\ResetDatabase;

class SecurityControllerTest extends WebTestCase
{
    use ResetDatabase;

    public function testSecurityController(): void
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/register_email', 
        array(),
        array(),
        array('CONTENT_TYPE' => 'application/json'),
            '[{
                "email": "babayaga@example.com",
                "name": "John",
                "surname": "Wick",
                "phoneNumber": "456345768",
                "birthDate": "1980-04-21",
                "currencies": {
                    "currency": "euro",
                        "min": "4.4000",
                        "max": "4.5000"
                }
            }]'
        );

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertEquals(
            200, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
        
        
    }
}#php bin/phpunit --filter=testSecurityController
