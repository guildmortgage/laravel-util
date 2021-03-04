<?php
/**
 * @copyright (c) 2020 Guild Mortgage Company. All rights reserved
 * @author Steve Oliver <steve.oliver@guildmortgage.net>
 */

namespace GuildMortgage\LaravelUtil\Tests\Functional\Jsend;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class JsendFunctionalTest extends TestCase
{
    /** @test */
    public function jsend_success_generates_a_response_with_status_code_200()
    {
        $response = jsend_success();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals(['status' => 'success', 'data' => null], json_decode($response->getContent(), true));

        $response = jsend_success('hi');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals(['status' => 'success', 'data' => 'hi'], json_decode($response->getContent(), true));
    }

    /** @test */
    public function jsend_success_works_with_eloquent_model_as_data()
    {
        $model = new class(['id' => 2, 'name' => 'Nein']) extends Model {
            public $id;
            public $name;
            protected $guarded = [];
        };

        $response = jsend_success($model);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals([
            'status' => 'success',
            'data' => ['id' => 2, 'name' => 'Nein']
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function jsend_error_generates_a_response_with_status_code_500()
    {
        $message = 'Something happened.';
        $response = jsend_error($message);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertEquals(['status' => 'error', 'message' => $message], json_decode($response->getContent(), true));
    }

    /** @test */
    public function jsend_fail_generates_a_response_with_status_code_400()
    {
        $message = 'Something happened.';
        $response = jsend_fail(['message' => $message]);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 400);
        $this->assertEquals([
            'status' => 'fail',
            'data' => ['message' => $message]
        ], json_decode($response->getContent(), true));
    }
}
