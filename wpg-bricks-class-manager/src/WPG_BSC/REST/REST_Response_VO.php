<?php

namespace WPG_BSC\REST;

class REST_Response_VO
{
    const STATE_OK = 'OK';
    const STATE_ERROR = 'ERROR';
    const STATE_WARNING = 'WARNING';

    public $message = null;
    public $status = 'OK';
    public $data = null;

    public function __construct($message, $data = null, $state = self::STATE_OK)
    {
        $this->data = $data;
        $this->status = $state;
        $this->message = $message;
    }

    /**
     * @return null
     */
    public function get_message()
    {
        return $this->message;
    }

    /**
     * @param null $message
     */
    public function set_message($message): void
    {
        $this->message = $message;
    }

    /**
     * @return null
     */
    public function get_status()
    {
        return $this->status;
    }

    /**
     * @param null $status
     */
    public function set_status($status): void
    {
        $this->status = $status;
    }

    /**
     * @return null
     */
    public function get_data()
    {
        return $this->data;
    }

    /**
     * @param null $data
     */
    public function set_data($data): void
    {
        $this->data = $data;
    }
}