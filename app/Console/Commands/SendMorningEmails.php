<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMorningEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'morning:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily morning mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('role_id', '=' , 2)->get();

        foreach ($users as $user)
        {
            $to_name = $user->name;
            $to_email = $user->email;
            $data = array('name' => $user->name, "body" => "This is Mail for Test schedule for sending email every Morning for all teacher roles");

            Mail::send('morningmail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Laravel Scheduling Mail - Laravel Traning');
            $message->from('mitesh.kadivar@bytestechnolab.in','Test Scheduling Mail');
            });

        }
    }
}
