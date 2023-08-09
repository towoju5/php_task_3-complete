<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('application/libraries/stripe-php/init.php');

class Stripe extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->helper('url');
    }

    public function checkout()
    {
        $this->load->view('checkout');
    }

    public function handlePayment()
    {
        $key = $this->config->item('stripe_secret');

        \Stripe\Stripe::setApiKey($key);
        header('Content-Type: application/json');

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => 1300,
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
