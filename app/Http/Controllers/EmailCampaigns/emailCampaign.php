<?php

namespace App\Http\Controllers\EmailCampaigns;

use App\Jobs\SendCampaignEmailJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;

class EmailCampaign extends BaseController
{
    protected function getDeviceType()
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            return 'm';
        } elseif ($agent->isTablet()) {
            return 't';
        } else {
            return 'd';
        }
    }

    public function trackEmail(Request $request)
    {
        $listId = $request->query('list_id');
        $campaignId = $request->query('campaign_id');
        $trackId = $request->query('track_id');


        $record = DB::table('xx_email_campaign_details')
            ->where('track_token', $trackId)
            ->first();

        if ($record) {
            DB::table('xx_email_campaign_details')
                ->where('id', $record->id)
                ->update([
                    'status' => 'opened',
                    'attr3' => now()->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s')
                ]);
        }
    }

    public function sentCampaignEmail(Request $request)
    {
        if (!$request->hasHeader('PHP_AUTH_USER') || !$request->hasHeader('PHP_AUTH_PW')) {
            return response('Unauthorized', 401, ['WWW-Authenticate' => 'Basic']);
        }
    
        $username = $request->header('PHP_AUTH_USER');
        $password = $request->header('PHP_AUTH_PW');
        if ($username !== 'bmp' || $password !== 'Bmp@3332') {
            return response('Invalid credentials', 401, ['WWW-Authenticate' => 'Basic']);
        }
    
        $listId = $request->query('list_id');
        $campaignId = 1;
    
        try {
            exec("ps aux | grep 'queue:work' | grep -v grep", $output);
            if (!empty($output)) {
                exec('pkill -f "php artisan queue:work"');
            }
    
            DB::table('jobs')->truncate();
    
            SendCampaignEmailJob::dispatch($listId, $campaignId);
            exec('php artisan queue:work --stop-when-empty --timeout=3600 > storage/logs/queue.log 2>&1 &');
    
            return response()->json([
                'status' => 'success',
                'message' => 'Latest email campaign started successfully.'
            ]);
    
        } catch (\Exception $e) {
            \Log::error("Campaign error: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error starting campaign: ' . $e->getMessage()
            ], 500);
        }
    }
}
