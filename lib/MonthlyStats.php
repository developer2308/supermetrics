<?php

require_once('./lib/Post.php');

class MonthlyStats implements JsonSerializable {

    /**
     * @var int the month of monthly stats
     */
    private int $month;

    /**
     * @var int the count of posts
     */
    private int $postCount = 0;

    /**
     * @var int[] the array of user ids
     */
    private $userIds = [];

    /**
     * @var int the total character length of all posts
     */
    private int $postLengthSum = 0;

    /**
     * @var Post the longest post by character length
     */
    private Post $longestPost;

    /**
     * Construct
     *
     * @param int $month
     */
    public function __construct(int $month) {
        $this->month = $month;
    }

    /**
     * Get month of monthly stats
     */
    public function getMonth(): int {
        return $this->month;
    }

    /**
     * Process a post and update monthly stats.
     *
     * @param Post $post
     */
    public function addPost(Post $post) {

        $this->postCount++;
        $this->postLengthSum += $post->getLength();

        if (!in_array($post->fromId, $this->userIds)) {
            $this->userIds[] = $post->fromId;
        }

        if (isset($this->longestPost)) {
            if ($this->longestPost->getLength() < $post->getLength()) {
                $this->longestPost = $post;
            }
        } else {
            $this->longestPost = $post;
        }
    }

    /**
     * format the float number
     */
    private function num_format(float $number) {
        return number_format($number, 1);
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return array
     */
    public function jsonSerialize() {
        $result = [
            'average_char_length_of_posts' => $this->num_format($this->postLengthSum / ($this->postCount?$this->postCount:0)),
            'longest_post' => $this->longestPost,
            'average_number_of_posts_per_user' => $this->num_format($this->postCount / (count($this->userIds)?count($this->userIds):1)),
            // 'post_count' => $this->postCount,
            // 'user_count' => count($this->userIds),
            // 'total_char_length' => $this->postLengthSum
        ];

        return $result;
    }
}
