<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportAnswer extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $user;
    public $answer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $message, \App\Models\Report $report,User $user)
    {
        $this->answer = $message;
        $this->report = $report;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pages.emails.report_answer',['report' => $this->report, 'user' => $this->user, 'answer' => $this->answer]);
    }
}
