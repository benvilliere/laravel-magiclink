<?php

namespace MagicLink\Test;

use Illuminate\Support\Facades\App;
use MagicLink\Actions\ResponseAction;
use MagicLink\Controllers\MagicLinkController;
use MagicLink\MagicLink;

class ConfigTest extends TestCase
{
    public function test_custom_token_length()
    {
        $this->app['config']->set('magiclink.token.length', 10);

        $url = MagicLink::create(new ResponseAction())->url;

        $this->assertEquals(10, strlen($this->getTokenFromUrl($url)));
    }

    protected function getTokenFromUrl($url)
    {
        $parts = explode(':', $url);

        return end($parts);
    }

    public function test_custom_url_validate_path()
    {
        $this->app['config']->set('magiclink.url.validate_path', 'otherpath');

        $url = MagicLink::create(new ResponseAction())->url;

        $this->assertGreaterThan(0, strpos($url, '/otherpath/'));
    }

    public function test_custom_url_redirect_default()
    {
        $this->app['config']->set('magiclink.url.redirect_default', '/dashboard');

        $url = MagicLink::create(new ResponseAction())->url;

        if (preg_match('/5\.5\.*/', App::version())) {
            $this->get($url)
                ->assertStatus(302);
        } else {
            $this->get($url)
                ->assertStatus(302)
                ->assertRedirect('/dashboard');
        }
    }

    public function test_custom_response_error()
    {
        $this->app['config']->set(
            'magiclink.response.error',
            response()->json(['message' => 'text json'], 422)
        );

        $response = (new MagicLinkController())->access('test');

        $this->assertEquals(422, $response->getStatusCode());
    }
}
