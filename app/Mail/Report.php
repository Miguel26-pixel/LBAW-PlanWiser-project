<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Report extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $user;
    public $user_reported;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Report $report,User $user, $user_reported)
    {
        $this->report = $report;
        $this->user = $user;
        $this->user_reported = $user_reported;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pages.emails.report',['report' => $this->report, 'user' => $this->user, 'user_reported' => $this->user_reported])->subject('Report');
    }
}
