<?php

namespace App\Mail;

use App\Models\HolidayPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HolidayPlanCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $holidayPlan;

    public function __construct(HolidayPlan $holidayPlan)
    {
        $this->holidayPlan = $holidayPlan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Holiday Plan Created')
            ->view('emails.holiday_plan_created')
            ->with(['holidayPlan' => $this->holidayPlan])
            ->withSwiftMessage(function ($message) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
            });
    }
}
