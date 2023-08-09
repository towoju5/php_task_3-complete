<?php

// use Da\TwoFA\Manager;
defined('BASEPATH') or exit('No direct script access allowed');
require_once('application/libraries/amigos_2fa/index.php');

class Welcome extends CI_Controller
{
	public $output;
	public $input;
	public $curl;
	public $db;


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function twofa()
	{
		if($_POST){
			$_SESSION['AUTHKEY'] = $this->input->post('secret');
			$status = Amigos::verify($this->input->post('code'), $_SESSION['AUTHKEY']);
			if(!$status) {
				$this->session->set_flashdata('message', 'Invalid code supplied');
				return redirect('welcome/twofa');
			}
			$this->session->set_flashdata('message', 'That\'s it man. You got the drill');
			return redirect('welcome/twofa');
		}
		$code = Amigos::getCode();
		return $this->load->view('auth', $code);
	}

	public function verifyTwoFa()
	{
		$manager = new Manager();
		$user = new stdClass();
		$user->twofa_secret = "";
		$valid = $manager->verify($_POST['key'], $user->twofa_secret);
	}

	public function index()
	{
		$data['image'] = $this->getLatestImage();
		$data['reddit'] = self::reddit() ?? [];
		$this->load->view('index', $data);
	}

	public function search()
	{
		$query = $this->input->get('query', true);
		$csvFilePath = "./airports.csv";
		$results = self::searchCSV($query, $csvFilePath);
		// $request =  self::request('search.json', $query);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode(to_array($results)));
	}

	public function old_weather()
	{
		$query = $this->input->get('query', true);
		$request =  self::request('current.json', $query);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode(to_array($request)));
	}

	public function weather()
	{
		$city = 'London'; // Replace with the desired city
		$weather_data = $this->fetchWeatherData($city);

		if ($weather_data) {
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($weather_data));
		} else {
			$this->output->set_status_header(500);
			$this->output->set_output('Error fetching weather data from the API.');
		}
	}

	public function timezone()
	{
		date_default_timezone_set('UTC');
		$utc_time = time();

		// Convert UTC time to local times (London, EST, Nigeria, and Pakistan)
		$london_time = $this->convertToTimezone($utc_time, 'Europe/London');
		$est_time = $this->convertToTimezone($utc_time, 'America/New_York');
		$nigeria_time = $this->convertToTimezone($utc_time, 'Africa/Lagos');
		$pakistan_time = $this->convertToTimezone($utc_time, 'Asia/Karachi');

		$data = [
			'utc_time' => date('H:i:s', $utc_time),
			'london_time' => date('H:i:s', $london_time),
			'est_time' => date('H:i:s', $est_time),
			'nigeria_time' => date('H:i:s', $nigeria_time),
			'pakistan_time' => date('H:i:s', $pakistan_time),
		];

		// Return the data as JSON response
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($data));
	}


	private function convertToTimezone($timestamp, $timezone)
	{
		$date_time = new DateTime("@$timestamp");
		$date_time->setTimezone(new DateTimeZone($timezone));
		return $date_time->getTimestamp();
	}

	public function reddit()
	{
		try {
			$url = 'https://www.reddit.com/r/programming.json';
			// Fetch data from Reddit API
			$this->load->library('curl');
			$json_response = $this->curl->simple_get($url);
			$reddit_data = json_decode($json_response, true);
			if (isset($reddit_data['data']['children'])) {
				$even_posts = array_filter($reddit_data['data']['children'], function ($post) {
					return $post['data']['score'] % 2 === 0;
				});
				$top_4_even_posts = array_slice($even_posts, 0, 4);
				$reddit_posts = $top_4_even_posts;
				// var_dump($reddit_posts); exit;
				return $reddit_posts;
			}
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

	public function update_widget()
	{
		if (isset($_REQUEST["widget-name"])) {
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			if (preg_match('/MSIE|Trident/i', $userAgent)) {
				$browser = 'Internet Explorer';
			} elseif (preg_match('/Firefox/i', $userAgent)) {
				$browser = 'Mozilla Firefox';
			} elseif (preg_match('/Chrome/i', $userAgent)) {
				$browser = 'Google Chrome';
			} elseif (preg_match('/Safari/i', $userAgent)) {
				$browser = 'Apple Safari';
			} elseif (preg_match('/Opera|OPR/i', $userAgent)) {
				$browser = 'Opera';
			} else {
				$browser = 'Unknown';
			}

			$widget_name = $this->input->get('widget-name');

			$data = array(
				'widget_name' => $widget_name,
				'browser_type' => $browser
			);

			$this->db->insert('analytic', $data);
			echo json_encode(['success' => true, 'data' => "Record logged successfully"]);
		} else {
			$this->rate_limit->check(10, 60);
			echo json_encode(['success' => true, 'data' => count($this->db->get('analytic')->result_array())]);
		}
	}

	public function export()
	{
		$query = $this->db->get('analytic');
		$data['items'] = $query->result();
		$xml_data = $this->load->view('xml_export', $data, TRUE);
		header('Content-Type: application/xml');
		header('Content-Disposition: attachment; filename="exported_data.xml"');

		// Output the XML content
		echo $xml_data;
	}

	public function calculate_coins()
	{
		$result = null;
		$amount = $this->input->post('amount');
		$bills = [20, 10, 5, 1, 0.25, 0.1, 0.05, 0.01];
		$billNames = ["$20 bills", "$10 bills", "$5 bills", "$1 bills", "25 nickels", "10 dimes", "5 nickels", "1 penny"];

		for ($i = 0; $i < count($bills); $i++) {
			if ($amount >= $bills[$i]) {
				$count = floor($amount / $bills[$i]);
				$result .= $count . "x " . $billNames[$i] . "<br>";
				$amount -= $count * $bills[$i];
			}
		}

		echo json_encode(["status" => true, "result" => $result]);
		exit;
	}

	public function image()
	{
		try {
			$config['upload_path'] = 'uploads';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = 2048; // 2MB
			$config['max_width'] = 1600;
			$config['max_height'] = 1200;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('image')) {
				$upload_data = $this->upload->data();
				$image_data = array(
					'filename' => 'uploads/' . $upload_data['file_name']
				);

				$this->db->insert('images', $image_data);
				redirect(base_url('/'));
			} else {
				$error = $this->upload->display_errors();
				echo $error;
			}
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	private function fetchWeatherData()
	{
		$query = $this->input->get('query', true);
		$arr = ['key' => API_KEY, 'q' =>  $query];
		$url = 'https://api.weatherapi.com/v1/current.json?key=' . http_build_query($arr);

		$this->load->library('curl');
		$json_response = $this->curl->simple_get($url);

		if ($json_response) {
			$weather_data = json_decode($json_response, true);
			return $weather_data;
		}

		return false;
	}
	private function request($method, $query)
	{
		$arr = ['key' => API_KEY, 'q' =>  $query];
		$url = "http://api.weatherapi.com/v1/$method?" . http_build_query($arr);
		// var_dump($arr); exit;
		$request = file_get_contents($url);
		return  $request;
	}

	private function getLatestImage()
	{
		$query = $this->db->order_by('id', 'desc')->get('images', 1)->row();
		// var_dump($query); exit;
		if (empty($query)) {
			return $query = "https://t3.ftcdn.net/jpg/05/01/98/72/360_F_501987255_kb5LZcBmlcz00IejLlxpklpTbJ9ys5i8.jpg";
		}
		return base_url($query->filename);
	}

	function searchCSV($query, $csvFilePath)
	{
		$suggestions = [];

		if (($handle = fopen($csvFilePath, 'r')) !== false) {
			while (($data = fgetcsv($handle, 1000, ',')) !== false) {
				foreach ($data as $cell) {
					if (stripos($cell, $query) !== false && !in_array($data, $suggestions)) {
						$suggestions[] = $data;
					}
				}
			}
			fclose($handle);
		}

<<<<<<< HEAD
		return $suggestions;
=======
        // Output the XML content
        echo $xml_data;
    }

	public function chat(){
		return $this->load->view('chat');
	}

	public function sendChat(){
		$this->load->database();
		$message = $this->input->post('message');
		$data = [
            'chat_messages' => $message
        ];
        $this->db->insert('chat', $data);
		echo json_encode($message);
	}

	public function getChat(){
		$this->load->database();
        $query = $this->db->get('chat')->result();
		if (empty($query)) {
			return true;
		}
		echo json_encode($query);
>>>>>>> fe6b33acd46739a9bdc01c036610598a520cd20c
	}
}
