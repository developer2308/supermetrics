<?php

require_once('./lib/HttpClient.php');
require_once('./lib/MonthlyStats.php');

class Stats implements JsonSerializable {

    /**
     * @var array [month => MonthlyStats]
     */
    private $postsPerMonth = [];

    /**
     * @var array [week => int]
     */
    private $postsPerWeek = [];

    /**
     * Process a post and update $postsPerMonth and $postsPerWeek.
     *
     * @param Post $post
     */
    public function addPost(Post $post) {
        $month = $post->getMonth();

        if (!isset($this->postsPerMonth[$month])) {
            $this->postsPerMonth[$month] = new MonthlyStats($month);
        }

        $monthlyStats = $this->postsPerMonth[$month];
        $monthlyStats->addPost($post);

        $week = $post->getWeek();
        if (!isset($this->postsPerWeek[$week])) {
            $this->postsPerWeek[$week] = 1;
        } else {
            $this->postsPerWeek[$week]++;
        }
    }

    /**
     * Fetch and process the posts from api endpoint
     *
     * @param string $clientId
     * @param string $email
     * @param string $name
     */
    public function run($clientId, $email, $name) {
        $httpClient = new HttpClient($clientId, $email, $name);
        for($i = 1; $i <= 10; $i++) {
            $response = $httpClient->fetchPosts($i);
            if ($response) {
                foreach($response['data']['posts'] as $post) {
                    $post = new Post($post);
                    $this->addPost($post);
                }
            }
        }
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return array
     */
    public function jsonSerialize() {
        $result = [
            'monthly_stats' => $this->postsPerMonth,
            'total_posts_split_by_week_number' => $this->postsPerWeek,
        ];
        return $result;
    }
}
