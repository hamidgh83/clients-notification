<?php

namespace App\Jobs;

use App\Events\NotificationSent;
use App\Models\Notifications;
use App\Models\User as Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $method = 'send' . Str::ucfirst($this->queue);

        if (method_exists($this, $method))  {
            $client = Client::find($this->data['user_id']);
            if ($this->{$method}($client)) {
                $notification = Notifications::find($this->data['id']);
                
                event(new NotificationSent($notification));
            }
        }
    }

    protected function sendEmail(Client $client)
    {
        if ($client instanceof Client) {
            Mail::send('email', ['content' => $this->data['content'] ?? null], function($message) use ($client) {
                $message->to($client->email, $client->first_name . ' ' . $client->last_name)
                    ->subject('Notification message')
                    ->from('agent@example.com', 'Agent');
            });
            
            Log::info(sprintf("Email sent to %s.", $client->email));

            return true;
        }

        return false;
    }
    
    protected function sendSms(Client $client)
    {
        // Send sms
        
        Log::info(sprintf("SMS sent to %s.", $client->email));

        return true;
    }
}
