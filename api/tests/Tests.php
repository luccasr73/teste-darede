<?php


class Tests extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testVersion()
    {
        $this->json('GET', '/api/versao')
             ->seeJsonEquals([
                 'versao' => '1',
        ])
        ->assertResponseStatus(200);
    }

    
}
