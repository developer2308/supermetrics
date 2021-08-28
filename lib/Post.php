<?php

class Post implements JsonSerializable {
    /**
     * @var string describe ID of Post
     */
    public string $id;

    /**
     * @var string describe User ID of Post
     */
    public string $fromId;

    /**
     * @var string describe the message of Post
     */
    public string $message;

    /**
     * @var string describe the created time of Post
     */
    public string $createdTime;


    /**
     * Constructor
     *
     * @param array $post a post
     */
    public function __construct(array $post){
        $this->id = $post['id'];
        $this->fromId = $post['from_id'];
        $this->message = $post['message'];
        $this->createdTime = $post['created_time'];
    }

    /**
     * Get the created month of Post
     *
     * @return int created month of Post
     */
    public function getMonth(): int {
        return (int)date("m", strtotime($this->createdTime));
    }

    /**
     * Get the created week of Post
     *
     * @return int create week of Post
     */
    public function getWeek(): int {
        return (int)date("W", strtotime($this->createdTime));
    }

    /**
     * Get the length of message
     *
     * @return int
     */
    public function getLength(): int {
        return mb_strlen($this->message);
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return array
     */
    public function jsonSerialize() {
        $result = [
            'id' => $this->id,
            'from_id' => $this->fromId,
            'length' => $this->getLength(),
        ];

        return $result;
    }
}
