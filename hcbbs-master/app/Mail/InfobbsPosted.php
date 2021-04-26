<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InfobbsPosted extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * ビューのデータ
     * @var array
     */
    private $view_data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $view_data )
    {
        $this->view_data = $view_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.upload', $this->view_data);
                //->subject( $this->view_data['subject'] );
    }
}
