<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_creating_order()
    // {
    //     $user = User::factory()->create();
    //     $response = $this->postJson(
    //         route('api.collaborators.list'),
    //         [
    //             'product_id' => $user->id,
    //         ]
    //     );
    //     $response->assertStatus(201);
    // }

    public function test_sendgrid_send_email()
    {
        $email = new \SendGrid\Mail\Mail();
        $templateId = 'd-3ba931ea440e4c4b82c5c7a8ead37554';
        $email->setFrom(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
        $email->setSubject("Sending with SendGrid is Fun");
        $email->addTo('rodolfoneto@gmail.com', 'Rodolfo A A Neto');
        // $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        // $email->addContent(
        //     "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        // );
        $email->addDynamicTemplateDatas([
            "customer_name" => "Rodolfo",
            "order_id" => "123132",
            "order_value" => "1000.00",
            "deadline" => "7",
            "to_name" => "Taciana",
            "occasion" => "festinha",
            "instructions" => "jhdsgfkajhfgakjhdf gaskjhfgaskjd fhgaskjfgaskj dhfgaksjdhfg"
        ]);
        $email->setTemplateId($templateId);
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}
