<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SendCampaignEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $listId;
    protected $campaignId;
    protected $columns;
    protected $subject;

    /**
     * Create a new job instance.
     */
    public function __construct($listId, $campaignId)
    {
        $this->listId = $listId;
        $this->campaignId = $campaignId;
        $this->columns = ['sport', 'name', 'email', 'locality_name', 'city', 'state'];
        $this->subject = "🚀 Find Your Perfect Training Spot with BookMyPlayer! 🌟🏆";
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $masterList = DB::table('xx_email_list')->where('id', $this->listId)->first();
        if (!$masterList) {
            \Log::error("Master list not found for ID: {$this->listId}");
            return;
        }

        $campaign = DB::table('xx_email_campaigns')->where('id', $this->campaignId)->first();
        if (!$campaign) {
            \Log::error("Campaign not found for ID: {$this->campaignId}");
            return;
        }

        $campaignEmails = DB::table('xx_email_list_details')
            ->whereIn('id', explode(',', $masterList->list_details))
            ->get();

        if ($campaignEmails->isEmpty()) {
            \Log::error("Emails not found for campaign: {$this->campaignId}");
            return;
        }

        foreach ($campaignEmails as $campaignEmail) {
            $unsubToken = Str::random(15);
            $isSpamEmail = checkSpamEmail($campaignEmail->email);
            if ($isSpamEmail) {
                continue;
            }

            $placeholders = [];
            foreach ($this->columns as $column) {
                $placeholders["{{$column}}"] = $campaignEmail->$column;
            }

            $placeholders['{{pixel_url}}'] = "https://www.bookmyplayer.com/track-email?list_id={$campaignEmail->id}&campaign_id={$this->campaignId}&track_id={$unsubToken}";
            $placeholders['{{unsubscribe_token}}'] = $unsubToken;
            $emailHtml = str_replace(array_keys($placeholders), array_values($placeholders), $campaign->template_html);
            // $isSent = send_campaign_email($campaignEmail->email, $this->subject, $emailHtml, $unsubToken, $this->campaignId);

            // if ($isSent) {
                DB::table('xx_email_campaign_details')->insert([
                    'list_id' => $campaignEmail->id,
                    'campaign_id' => $this->campaignId,
                    'status' => 'sent',
                    'track_token' => $unsubToken

                ]);
            // }
        }

        \Log::info("All emails sent for campaign {$this->campaignId}.");
    }
}
