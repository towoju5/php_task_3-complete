<?php

class Rate_limit {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->driver('cache');
    }

    public function check($limit, $interval) {
        $ip = $this->CI->input->ip_address();
        $key = 'ratelimit:' . $ip;

        $rateLimit = $this->CI->cache->get($key);
        if (!$rateLimit) {
            $rateLimit = [
                'count' => 0,
                'last_request' => time()
            ];
        }

        $now = time();
        if ($now - $rateLimit['last_request'] > $interval) {
            // Reset count and update last request time
            $rateLimit['count'] = 1;
            $rateLimit['last_request'] = $now;
        } else {
            $rateLimit['count']++;
        }

        if ($rateLimit['count'] > $limit) {
            show_error('Rate limit exceeded', 429);
        }

        $this->CI->cache->save($key, $rateLimit, $interval);

        return $this;
    }
}
