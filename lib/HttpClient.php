<?php

class HttpClient {

    const URL_PREFIX = 'https://api.supermetrics.com/assignment';
    private $clientId;
    private $email;
    private $name;
    private $token;

    public function __construct(string $clientId, string $email, string $name) {
        $this->clientId = $clientId;
        $this->email = $email;
        $this->name = $name;

        $this->register();
    }

    /**
     * call GET request
     *
     * @param string $url GET url
     *
     * @return false|array the result on success, false on failure.
     */
    private function get(string $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            return json_decode($response, true);
        } else {
            return false;
        }
    }

    /**
     * call POST request
     *
     * @param string $url POST url
     * @param array $params POST parameters
     *
     * @return false|array the result on success, false on failure.
     */
    private function post(string $url, array $params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            return json_decode($response, true);
        } else {
            return false;
        }
    }

    /**
     * Register a token
     */
    public function register() {
        $url = self::URL_PREFIX . "/register";
        $params = [
            'client_id' => $this->clientId,
            'email' => $this->email,
            'name' => $this->name,
        ];
        $response = $this->post($url, $params);
        if ($response && $response['data']['sl_token']) {
            $this->token = $response['data']['sl_token'];
        }
    }

    /**
     * Fetch posts
     *
     * @param int $page page number of posts
     *
     * @return false|array the result on success, false on failure.
     */
    public function fetchPosts(int $page) {
        if (!$this->token) {
            $this->register();
        }

        if ($this->token) {
            $url = self::URL_PREFIX . "/posts?sl_token={$this->token}&page={$page}";
            $response = $this->get($url);
            return $response;
        } else {
            return false;
        }
    }
}
