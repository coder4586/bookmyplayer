<?php

use App\Models\xx_emails;

function get_data_row($site = null, $table = null, $column = null, $value = null, $column2 = null, $value2 = null, $order_column = null, $order_value = 'asc')
{
    $query = DB::table($table);
    if (!is_null($column) && !is_null($value)) {
        $query->where($column, $value);
    }
    if (!is_null($column2) && !is_null($value2)) {
        $query->where($column2, $value2);
    }
    if (!is_null($site)) {
        $query->where('site', $site);
    }
    if (!is_null($order_column)) {
        $query->orderBy($order_column, $order_value);
    }
    return $query->first();
}

function get_data_row_3_conditions($site = null, $table = null, $column = null, $value = null, $column2 = null, $value2 = null, $column3 = null, $value3 = null, $order_column = null, $order_value = 'asc')
{
    $query = DB::table($table);
    if (!is_null($column) && !is_null($value)) {
        $query->where($column, $value);
    }
    if (!is_null($column2) && !is_null($value2)) {
        $query->where($column2, $value2);
    }
    if (!is_null($column3) && !is_null($value3)) {
        $query->where($column3, $value3);
    }
    if (!is_null($site)) {
        $query->where('site', $site);
    }
    if (!is_null($order_column)) {
        $query->orderBy($order_column, $order_value);
    }
    return $query->first();
}

function get_data_array($site = null, $table = null, $column1 = null, $value1 = null, $column2 = null, $value2 = null, $order_column = null, $order_value = 'asc', $limit = null)
{
    $query = DB::table($table);
    if (isset($column1) && isset($value1)) {
        $query->where($column1, $value1);
    }
    if (isset($column2) && isset($value2)) {
        $query->where($column2, $value2);
    }
    if (isset($site)) {
        $query->where('site', $site);
    }
    if (isset($order_column)) {
        $query->orderBy($order_column, $order_value);
    }
    if ($limit !== null) {
        $query = $query->limit($limit);
    }
    $result = $query->get();
    return $result;
}

function get_data_array_three_conditions($site = null, $table = null, $column1 = null, $value1 = null, $column2 = null, $value2 = null, $column3 = null, $value3 = null, $order_column = null, $order_value = 'asc', $limit = null)
{
    $query = DB::table($table);
    if (isset($column1) && isset($value1)) {
        $query->where($column1, $value1);
    }
    if (isset($column2) && isset($value2)) {
        $query->where($column2, $value2);
    }
    if (isset($column3) && isset($value3)) {
        $query->where($column3, $value3);
    }
    if (isset($site)) {
        $query->where('site', $site);
    }
    if (isset($order_column)) {
        $query->orderBy($order_column, $order_value);
    }
    if ($limit !== null) {
        $query = $query->limit($limit);
    }
    $result = $query->get();
    return $result;
}

function get_data_array_skip($site = null, $table = null, $column1 = null, $value1 = null, $column2 = null, $value2 = null, $order_column = null, $order_value = 'asc', $limit = null, $skip = null)
{
    $query = DB::table($table);
    if (isset($column1) && isset($value1)) {
        $query->where($column1, $value1);
    }
    if (isset($column2) && isset($value2)) {
        $query->where($column2, $value2);
    }
    if (isset($site)) {
        $query->where('site', $site);
    }
    if (isset($order_column)) {
        $query->orderBy($order_column, $order_value);
    }
    if ($skip !== null) {
        $query->skip($skip)->take($limit);
    } elseif ($limit !== null) {
        $query = $query->limit($limit);
    }
    $result = $query->get();
    return $result;
}

function get_data_array_or_like($site = null, $table = null, $column = null, $value = null, $orderColumn = null, $orderValue = 'asc')
{
    $query = DB::table($table);
    if (isset($column) && isset($value)) {
        $query->where($column, 'like', '%' . $value . '%');
    }
    if (isset($site)) {
        $query->where('site', '=', $site);
    }
    if (isset($orderColumn)) {
        $query->orderBy($orderColumn, $orderValue);
    }
    $result = $query->get();
    return $result;
}

function get_data_array_where_in($site = null, $table = null, $column = null, $value = null, $orderColumn = null, $orderValue = null)
{
    $query = DB::table($table);
    if (!is_null($column) && !is_null($value)) {
        $query->whereIn($column, $value);
    }
    if (!is_null($site)) {
        $query->where('site', $site);
    }
    if (!is_null($orderColumn) && !is_null($orderValue)) {
        $query->orderBy($orderColumn, $orderValue);
    }
    return $query->get()->toArray();
}


function redirecturl($url, $section = null)
{
    $data = get_data_row(null, 'xx_redirect', 'old_url', 'https://www.bookmyplayer.com' . $url);
    if (isset($data)) {
        DB::table('xx_redirect')
            ->where('id', $data->id)
            ->increment('total', 1);

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $data->new_url);
        exit;
    } else {

        DB::table('xx_log')->insert([
            'attr3' => 'https://www.bookmyplayer.com' . $url,
            'attr6' => '404',
            'attr7' => 'Redirect Missing',
        ]);
        header("Location: https://www.bookmyplayer.com/404");
        exit;

        //return response()->view('errors.404', [], 404);
    }
}

function getDeviceType()
{
    $agent = new \Jenssegers\Agent\Agent();

    if ($agent->isMobile()) {
        return 'm';
    } elseif ($agent->isTablet()) {
        return 't';
    } else {
        return 'd';
    }
}

//VG:-15Apr:- Delete if not required
function getNearbyAcademy($tbl, $lat, $lng, $radius, $count, $conditions = [], $sortColumn = 'distance', $sortOrder = 'ASC')
{
    $sql = "
        SELECT
            $tbl.name,$tbl.phone,$tbl.lat,$tbl.lng,$tbl.loc_id,$tbl.sport_id,$tbl.sport,$tbl.city,$tbl.phone,$tbl.url,$tbl.sport,$tbl.address1,$tbl.address2,$tbl.city,$tbl.state,$tbl.postcode,$tbl.logo,$tbl.photos,$tbl.fee,$tbl.rating,$tbl.reviews,$tbl.views,$tbl.id,
            bmp_default.default_pricing,
            (6371 * acos(
                cos(radians($lat)) * cos(radians(lat)) * cos(
                    radians(lng) - radians($lng)
                ) + sin(radians($lat)) * sin(radians(lat))
            )) AS distance
        FROM $tbl
        LEFT JOIN bmp_default_academy_pricing bmp_default ON $tbl.sport = bmp_default.sport";

    if (!empty($conditions)) {
        $sql .= " WHERE ";
        $conditionsSql = [];
        foreach ($conditions as $column => $value) {
            $conditionsSql[] = "$column = ?";
        }
        $sql .= implode(" AND ", $conditionsSql);
    }

    $sql .= " HAVING distance < ?";

    $sql .= " ORDER BY $sortColumn $sortOrder LIMIT 0, ?";

    $bindings = array_values($conditions);
    $bindings[] = $radius;
    $bindings[] = $count;

    $data = DB::select($sql, $bindings);

    return $data;
}


function getNearbyAcademy_vg($tbl, $lat, $lng, $radius, $count, $conditions = [], $sortColumn = 'distance', $sortOrder = 'ASC')
{
    $sql = "
        SELECT
            $tbl.name,$tbl.loc_id,$tbl.review_summary,$tbl.url,$tbl.sport,$tbl.sport_id,$tbl.lat,$tbl.lng,$tbl.address1,$tbl.address2,$tbl.city,$tbl.state,$tbl.postcode,$tbl.logo,$tbl.photos,$tbl.fee,$tbl.rating,$tbl.reviews,$tbl.views,$tbl.id,$tbl.default_pricing,
            (6371 * acos(
                cos(radians($lat)) * cos(radians(lat)) * cos(
                    radians(lng) - radians($lng)
                ) + sin(radians($lat)) * sin(radians(lat))
            )) AS distance
        FROM $tbl";

    $sql .= " HAVING distance < ?";
    $sql .= " ORDER BY $sortColumn $sortOrder LIMIT 0, ?";
    $bindings = array_values($conditions);
    $bindings[] = $radius;
    $bindings[] = $count;
    $data = DB::select($sql, $bindings);
    return $data;
}


function getNearbyAcademy_vi($tbl, $lat, $lng, $radius, $count, $sportvalue, $sortColumn = 'distance', $sortOrder = 'ASC')
{
    $sql = "
        SELECT
            *,
            (6371 * acos(
                cos(radians($lat)) * cos(radians(lat)) * cos(
                    radians(lng) - radians($lng)
                ) + sin(radians($lat)) * sin(radians(lat))
            )) AS distance
        FROM $tbl where sport_id = '$sportvalue'";

    $sql .= " HAVING distance < ?";
    $sql .= " ORDER BY $sortColumn $sortOrder LIMIT 0, ?";
    $bindings[] = $radius;
    $bindings[] = $count;
    $data = DB::select($sql, $bindings);
    return $data;
}

// 16 Aug(new academy listing with filters)
function getNearbyAcademy_mm($tbl, $lat, $lng, $radius, $count, $conditions = [], $sortColumn = 'distance', $sortOrder = 'ASC')
{
    $sql = "
        SELECT
            $tbl.name, $tbl.loc_id, $tbl.review_summary, $tbl.url, $tbl.sport, $tbl.sport_id, $tbl.lat, $tbl.lng, $tbl.address1, $tbl.address2, $tbl.city, $tbl.state, $tbl.postcode, $tbl.logo, $tbl.photos, $tbl.fee, $tbl.rating, $tbl.reviews, $tbl.views, $tbl.id, $tbl.default_pricing,
            (6371 * acos(
                cos(radians($lat)) * cos(radians(lat)) * cos(
                    radians(lng) - radians($lng)
                ) + sin(radians($lat)) * sin(radians(lat))
            )) AS distance
        FROM $tbl";

    if (!empty($conditions)) {
        $sql .= " WHERE ";
        $conditionClauses = [];
        $bindings = [];

        foreach ($conditions as $column => $condition) {
            if (is_array($condition)) {
                if (isset($condition['operator']) && strtolower($condition['operator']) == 'in') {
                    $placeholders = implode(',', array_fill(0, count($condition['values']), '?'));
                    $conditionClauses[] = "$column IN ($placeholders)";
                    $bindings = array_merge($bindings, $condition['values']);
                } else {
                    $conditionClauses[] = "$column {$condition['operator']} ?";
                    $bindings[] = $condition['value'];
                }
            } else {
                $conditionClauses[] = "$column = ?";
                $bindings[] = $condition;
            }
        }

        $sql .= implode(" AND ", $conditionClauses);
    }

    $sql .= " HAVING distance < ?";
    $sql .= " ORDER BY $sortColumn $sortOrder LIMIT 0, ?";

    $bindings[] = $radius;
    $bindings[] = $count;

    $data = DB::select($sql, $bindings);
    return $data;
}


function getnearbylocations($lat, $lng, $radius)
{
    $sql = "
        SELECT
            *,
            (6371 * acos(
                cos(radians($lat)) * cos(radians(lat)) * cos(
                    radians(lng) - radians($lng)
                ) + sin(radians($lat)) * sin(radians(lat))
            )) AS distance
        FROM adm_location_master
        HAVING distance < ?
        ORDER BY distance";

    $bindings[] = $radius;

    $data = DB::select($sql, $bindings);
    return $data;
}

function redirectTo($sport)
{
    $data = get_data_row(null, 'bmp_sports', 'sport', $sport, 'type', 'core');

    if ($data) {
        return $data->url;
    } else {
        return "https://www.bookmyplayer.com/";
    }
}

function createLog($attr1 = null, $attr2 = null, $attr3 = null, $attr4 = null, $attr5 = null, $attr6 = null, $attr7 = null, $attr8 = null)
{
    DB::table('xx_log')->insert([
        'attr1' => $attr1,
        'attr2' => $attr2,
        'attr3' => $attr3,
        'attr4' => $attr4,
        'attr5' => $attr5,
        'attr6' => $attr6,
        'attr7' => $attr7,
        'attr8' => $attr8,
    ]);
}

function createAdminLog($attr1 = null, $attr2 = null, $attr3 = null, $attr4 = null, $attr5 = null, $attr6 = null, $attr7 = null, $attr8 = null)
{
    DB::connection('mysql_admin')->table('adm_log')->insert([
        'attr1' => $attr1,
        'attr2' => $attr2,
        'attr3' => $attr3,
        'attr4' => $attr4,
        'attr5' => $attr5,
        'attr6' => $attr6,
        'attr7' => $attr7,
        'attr8' => $attr8,
    ]);
}


function isValidEmail($email)
{
    $email = trim($email);
    $apiKey = env('NEVERBOUNCE_API_KEY');

    $isEmailUnsubscribed = get_data_row(null, 'xx_emails', 'email', $email, 'is_unsubscribed', 1);
    $isEmailAlreadyMarkedValid = get_data_row(null, 'xx_emails', 'email', $email, 'no_bounce_verified', 1);
    $isEmailAlreadyMarkedInValid = get_data_row(null, 'xx_emails', 'email', $email, 'no_bounce_verified', 0);

    if ($isEmailAlreadyMarkedInValid || $isEmailUnsubscribed || $email == "bmpregistrationmail@gmail.com") {
        return false;
    }
    if ($isEmailAlreadyMarkedValid) {
        return true;
    }

    $response = Http::post("https://api.neverbounce.com/v4/single/check?key=$apiKey&email=" . urlencode($email));

    if ($response->successful()) {
        $result = $response->json()['result'];
        if ($result === 'valid' || $result === 'disposable') {
            return true;
        } else {
            DB::table('xx_emails')
                ->insert([
                    'email' => $email,
                    'no_bounce_verified' => 0,
                    'remark' => $result,
                    'email_verified' => 0,
                    'creation_date' => now()
                ]);
            return false;
        }
    } else {
        DB::table('xx_emails')
            ->insert([
                'email' => $email,
                'no_bounce_verified' => 0,
                'remark' => 'API request failed',
                'email_verified' => 0,
                'creation_date' => now()
            ]);
        return false;
    }
}


function send_campaign_email($email, $sub, $html, $unsubToken, $campaign)
{
    // $isEmailValid = isValidEmail($email);
    // if (!$isEmailValid) {
    //     return false;
    // }

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["campaign"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => $sub,
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $html]]
            ]);

    if ($res->status() == 202) {
        $xx_email = new xx_emails();
        $xx_email->email = $email;
        $xx_email->type = "campaign:" . $campaign;
        $xx_email->unsubscribe_token = $unsubToken;
        $xx_email->source = "-";
        $xx_email->save();

        return true;
    }

    return false;
}

// custom email
function send_custom_email($email, $name)
{
    if (stripos($email, 'test') !== false)
        return false;

    $isEmailValid = isValidEmail($email);

    if (!$isEmailValid) {
        return false;
    }

    $customHtml = str_replace(['{{name}}'], [$name], File::get(resource_path("views/email_templates/sports_template.html")));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["academy_coach_tournaments_announcement_diwali"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "🌟 Celebrate Diwali by Hosting Your Tournaments on BookMyPlayer.com! 🪔🏆",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $customHtml]]
            ]);


    if ($res->status() == 202) {
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => '',
            'source' => "",
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}

function send_otp_verification_email($email, $otp, $type)
{
    if (stripos($email, 'test') !== false)
        return false;

    $isEmailValid = isValidEmail($email);

    if (!$isEmailValid) {
        return false;
    }

    $otpHtml = str_replace(['{{otp}}'], [$otp], File::get(resource_path("views/email_templates/otp.html")));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["regular", "Test_1"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "Identity Verification OTP",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $otpHtml]]
            ]);


    if ($res->status() == 202) {
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => "",
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}

function sendWelcomeEmail($email, $name, $type, $source)
{
    if (stripos($email, 'test') !== false)
        return;

    $isEmailAlreadySend = null;
    if ($email != "vaneetg@gmail.com") {
        $isEmailAlreadySend = get_data_row(null, 'xx_emails', 'email', $email, 'type', 'welcome-email');
    }
    $isEmailValid = isValidEmail($email);

    if ($isEmailAlreadySend || !$isEmailValid) {
        return;
    }

    $unsubscribeToken = Str::random(50);
    $unsubscribe_link = "https://www.bookmyplayer.com/unsubscribe/" . $unsubscribeToken;
    $welcomeHtml = str_replace(['{{name}}', '{{unsubscribe_link}}'], [$name, $unsubscribe_link], File::get(resource_path('views/email_templates/welcome.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["welcome"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "Welcome to BookMyPlayer!",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $welcomeHtml]]
            ]);

    if ($res->status() == 202) {
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => $source,
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}

function sendPlayerPorfileUpdateEmail($email, $name, $url, $source)
{
    $type = "update-player-profile-28aug";
    if (stripos($email, 'test') !== false)
        return;

    $isEmailAlreadySend = null;
    if ($email != "vaneetg@gmail.com") {
        $isEmailAlreadySend = get_data_row(null, 'xx_emails', 'email', $email, 'type', $type);
    }
    $isEmailValid = isValidEmail($email);

    if ($isEmailAlreadySend || !$isEmailValid) {
        return;
    }

    $updatePlayerProfile = str_replace(['{{name}}', '{{url}}'], [$name, $url], File::get(resource_path('views/email_templates/player_profile_update_2024_08_28.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["update player profile 29 Aug 2024"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "🚀  Hi $name, Unlock New Opportunities - BookMyPlayer",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $updatePlayerProfile]]
            ]);

    if ($res->status() == 202) {
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => $source,
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}

function sendCoachPorfileUpdateEmail($email, $name, $url, $source)
{
    $type = "update-coach-profile-01September";
    if (stripos($email, 'test') !== false)
        return;

    $isEmailAlreadySend = null;
    if ($email != "vaneetg@gmail.com") {
        $isEmailAlreadySend = get_data_row(null, 'xx_emails', 'email', $email, 'type', $type);
    }
    $isEmailValid = isValidEmail($email);

    if ($isEmailAlreadySend || !$isEmailValid) {
        return;
    }

    $updateCoachProfile = str_replace(['{{name}}', '{{url}}'], [$name, $url], File::get(resource_path('views/email_templates/coach_profile_update_2024_09_02.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["update coach profile 02 September 2024"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "🚀  Hi $name, Unlock New Opportunities - BookMyPlayer",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $updateCoachProfile]]
            ]);

    if ($res->status() == 202) {
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => $source,
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}

function sendWelcomeEmailCoach($email, $name, $id, $url, $type, $source)
{
    if (stripos($email, 'test') !== false)
        return;

    $isEmailAlreadySend = null;
    if ($email != "vaneetg@gmail.com") {
        $isEmailAlreadySend = get_data_row(null, 'xx_emails', 'email', $email, 'type', 'welcome-email');
    }
    $isEmailValid = isValidEmail($email);

    if ($isEmailAlreadySend || !$isEmailValid) {
        return;
    }

    $unsubscribeToken = Str::random(50);
    $unsubscribe_link = "https://www.bookmyplayer.com/unsubscribe/" . $unsubscribeToken;
    $welcomeHtml = str_replace(['{{name}}', '{{id}}', '{{public_url}}'], [$name, $id, $url], File::get(resource_path('views/email_templates/coach_welcome.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["welcome coach"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "Welcome to BookMyPlayer!",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $welcomeHtml]]
            ]);

    if ($res->status() == 202) {
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => $source,
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}

function sendWelcomeEmailPlayer($email, $name, $id, $type, $url, $source)
{
    if (stripos($email, 'test') !== false)
        return;

    $isEmailAlreadySend = null;
    if ($email != "vaneetg@gmail.com") {
        $isEmailAlreadySend = get_data_row(null, 'xx_emails', 'email', $email, 'type', 'welcome-email');
    }
    $isEmailValid = isValidEmail($email);

    if ($isEmailAlreadySend || !$isEmailValid) {
        return;
    }

    $unsubscribeToken = Str::random(50);
    $unsubscribe_link = "https://www.bookmyplayer.com/unsubscribe/" . $unsubscribeToken;
    $welcomeHtml = str_replace(['{{name}}', '{{id}}', '{{public_url}}'], [$name, $id, $url], File::get(resource_path('views/email_templates/player_welcome.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["welcome player"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "Welcome to BookMyPlayer!",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $welcomeHtml]]
            ]);

    if ($res->status() == 202) {
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => $source,
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}

function sendWelcomeEmailAcademy($email, $name, $id, $type, $source)
{
    if (stripos($email, 'test') !== false)
        return;

    $isEmailAlreadySend = null;
    if ($email != "vaneetg@gmail.com") {
        $isEmailAlreadySend = get_data_row(null, 'xx_emails', 'email', $email, 'type', 'welcome-email');
    }
    $isEmailValid = isValidEmail($email);

    if ($isEmailAlreadySend || !$isEmailValid) {
        return;
    }

    $unsubscribeToken = Str::random(50);
    $unsubscribe_link = "https://www.bookmyplayer.com/unsubscribe/" . $unsubscribeToken;
    $welcomeHtml = str_replace(['{{name}}', '{{id}}'], [$name, $id], File::get(resource_path('views/email_templates/academy_welcome.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["welcome academy"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "Welcome to BookMyPlayer!",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $welcomeHtml]]
            ]);

    if ($res->status() == 202) {
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => $source,
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}


function sendAcademyInfoEmail($email, $name, $type, $source, $object_type, $object_id)
{
    if (stripos($email, 'test') !== false)
        return;

    $isAcademyDetailsAlreadySent = get_data_row(null, 'xx_emails', 'email', $email, 'type', "Academy-details: $object_id");
    $isEmailValid = isValidEmail($email);
    $isLimitExceeded = DB::table('xx_emails')->where('email', $email)->where('type', 'like', '%Academy-details%')->whereRaw('DATE(creation_date) = CURDATE()')->count();

    if ($isAcademyDetailsAlreadySent || !$isEmailValid || $isLimitExceeded > 2) {
        return;
    }

    $d = get_data_row(null, 'bmp_academy_details', 'id', $object_id, null, null);
    if (!$d) {
        return;
    }
    $sport = $d->sport ? $d->sport : "";
    $about = $d->about ? $d->about : "";
    if ($about == null || $about == "") {
        $defaultabout = get_data_row(null, 'bmp_about', 'object', 'academy', 'sport', $d->sport);
        $about = str_replace(['ACADEMY_NAME', 'CITY_NAME', 'ADDRESS1'], [$d->name, $d->city, $d->address2], $defaultabout->about);
    } elseif (strlen($about) < 500) {
        $defaultabout = get_data_row(null, 'bmp_about', 'object', 'academy', 'sport', $sport);
        $about = $about . "</br></br><b><u> Further information about the Academy: </b></u></br>" . str_replace(['ACADEMY_NAME', 'CITY_NAME', 'ADDRESS1'], [$d->name, $d->city, $d->address2], $defaultabout->about);
    }

    $faqs = get_data_array(null, 'bmp_sport_faq', 'sport', $sport, null, null, 'priority', 'asc', 20);
    $photos = explode(',', $d->photos);
    $banner = $d->banner == null || $d->banner == "" ? "https://res.cloudinary.com/cloud2cdn/image/upload/q_70/bookmyplayer/default/{$sport}_banner.webp" : "https://res.cloudinary.com/cloud2cdn/image/upload/q_90/bookmyplayer/academy/{$d->id}/{$d->banner}";
    $logo = is_null($d->logo) || $d->logo === "" ? "https://res.cloudinary.com/cloud2cdn/image/upload/q_70/bookmyplayer/default/academy_default_logo.webp" : "https://res.cloudinary.com/cloud2cdn/image/upload/q_70/bookmyplayer/academy/{$d->id}/{$d->logo}";
    $address = implode(', ', array_filter([$d->address1, $d->address2, $d->city, $d->state, $d->postcode]));
    $mobile = $d->phone ? $d->phone : "Not Available";
    $closed_on = $d->closed_on ? $d->closed_on : "8PM";
    $fee = $d->fee ? nl2br(htmlspecialchars($d->fee)) : "Not Available";
    $photos_count = $d->photos == null || $d->photos == "" ? 0 : count($photos);

    $timing = $d->timing ? $d->timing : "10AM to 8PM";
    $about = str_replace(array('<p>', '</p>'), '', $about);
    $about = '<p style="margin: 0; color: #444757;">' . nl2br(htmlspecialchars($about)) . '</p>';


    $faqHeading = null;
    foreach ($faqs as $faq) {
        if ($faq->title == 1) {
            $faqHeading = $faq->question;
            break;
        }
    }

    $faqs_html = '';
    $questionNumber = 1;

    foreach ($faqs as $faq) {
        if ($faq->title != 1 && $faq->title != 2) {
            $margin = ($questionNumber == 1) ? 'margin: 16px 0;' : 'margin: 8px 0;';

            $faqs_html .= '<table class="paragraph_block block-2" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; ' . $margin . '">';
            $faqs_html .= '<tr>';
            $faqs_html .= '<td class="pad">';
            $faqs_html .= '<div style="color:#101112;direction:ltr;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">';
            $faqs_html .= '<p style="margin: 0;"><strong>' . $questionNumber . '. ' . htmlspecialchars($faq->question) . '</strong></p>';
            $faqs_html .= '<p style="margin: 0;"><strong>Answer: </strong>' . htmlspecialchars($faq->answer) . '</p>';
            $faqs_html .= '</div>';
            $faqs_html .= '</td>';
            $faqs_html .= '</tr>';
            $faqs_html .= '</table>';
            $questionNumber++;
        }
    }

    $imageHtml = '';

    if ($photos_count > 0) {
        for ($i = 0; $i < count($photos); $i += 2) {
            $photo1 = "https://res.cloudinary.com/cloud2cdn/image/upload/q_10/bookmyplayer/academy/{$d->id}/{$photos[$i]}";
            $photo2 = isset($photos[$i + 1]) ? "https://res.cloudinary.com/cloud2cdn/image/upload/q_10/bookmyplayer/academy/{$d->id}/{$photos[$i + 1]}" : '';

            $imageHtml .= '<td class="column column-1" width="50%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 10px; padding-left: 5px; padding-right: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">';
            $imageHtml .= '<table class="image_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">';
            $imageHtml .= '<tr>';
            $imageHtml .= '<td class="pad" style="width:100%;">';
            $imageHtml .= '<div class="alignment" align="center" style="line-height:10px">';
            $imageHtml .= '<div style="max-width: 315px;"><img src="' . $photo1 . '" style="display: block; height: auto; border: 0; width: 100%;" width="315"></div>';
            $imageHtml .= '</div>';
            $imageHtml .= '</td>';
            $imageHtml .= '</tr>';
            $imageHtml .= '</table>';
            $imageHtml .= '<div class="spacer_block block-2" style="height:5px;line-height:5px;font-size:1px;">&#8202;</div>';

            $imageHtml .= '<table class="image_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">';
            $imageHtml .= '<tr>';
            $imageHtml .= '<td class="pad" style="width:100%;">';
            $imageHtml .= '<div class="alignment" align="center" style="line-height:10px">';
            $imageHtml .= '<div style="max-width: 315px;"><img src="' . $photo2 . '" style="display: block; height: auto; border: 0; width: 100%;" width="315"></div>';
            $imageHtml .= '</div>';
            $imageHtml .= '</td>';
            $imageHtml .= '</tr>';
            $imageHtml .= '</table>';

            $imageHtml .= '</td>';
        }
    }


    $welcomeHtml = str_replace(['{{logo}}', '{{banner}}', '{{name}}', '{{address}}', '{{faq_heading}}', '{{faqs_html}}', '{{about}}', '{{mobile}}', '{{sport}}', '{{closed_on}}', '{{timing}}', '{{fee}}', '{{imageHtml}}', '{{photos_count}}'], [$logo, $banner, $d->name, $address, $faqHeading, $faqs_html, $about, $mobile, $sport, $closed_on, $timing, $fee, $imageHtml, $photos_count], File::get(resource_path('views/email_templates/academyInfo.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["academy information email"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => ucwords(strtolower($d->name)) . " - Details"
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $welcomeHtml]]
            ]);

    if ($res->status() == 202) {
        createLog($object_id, request()->ip(), request()->url(), URL::previous(), getDeviceType(), "academy info. email sent", $email);
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => $source,
            'name' => $name,
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}


function sendEmailVerificationEmail($email, $name, $verification_link, $type, $source)
{
    if (stripos($email, 'test') !== false)
        return false;

    // $isemailSentBeforeDay = DB::table('xx_emails')->where('email', $email)->where('type', 'verify-email')->where('creation_date', '>=', DB::raw('NOW() - INTERVAL 24 HOUR'))->count();
    $isemailSentBeforeHour = DB::table('xx_emails')->where('email', $email)->where('type', 'verify-email')->where('creation_date', '>=', DB::raw('NOW() - INTERVAL 1 HOUR'))->count();
    $isEmailVerified = get_data_row(null, 'xx_emails', 'email', $email, 'email_verified', 1);
    $isEmailValid = isValidEmail($email);

    if (!$isEmailValid) {
        return "Invalid_email";
    }

    if ($isEmailVerified || $isemailSentBeforeHour > 0) {
        return false;
    }

    $randomToken = Str::random(40);
    $unsubscribeToken = Str::random(50);
    $verification_link = "https://www.bookmyplayer.com/verify-email/" . $randomToken;
    $unsubscribe_link = "https://www.bookmyplayer.com/unsubscribe-email/" . $unsubscribeToken;
    $verificationHtml = str_replace(['{{name}}', '{{verification_link}}', '{{user_email}}', '{{unsubscribe_link}}'], [$name, $verification_link, $email, $unsubscribe_link], File::get(resource_path('views/email_templates/verify_email.html')));


    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["email verification"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "Confirm Your Email Address - BookMyPlayer.com",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $verificationHtml]]
            ]);

    if ($res->status() == 202) {
        createLog(null, request()->ip(), request()->url(), URL::previous(), getDeviceType(), "verification email sent", $email);
        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => $source,
            'email_token' => $randomToken,
            'name' => $name,
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}

function sendReviewRequestEmail($email, $name, $type, $source, $link)
{
    if (stripos($email, 'test') !== false)
        return;

    $isEmailAlreadySend = get_data_row(null, 'xx_emails', 'email', $email, 'type', 'review-request');
    $isEmailValid = isValidEmail($email);

    // if ($isEmailAlreadySend || !$isEmailValid) {
    //     return;
    // }

    $reviewRequestHtml = str_replace(['{{review_url}}'], [$link], File::get(resource_path('views/email_templates/review_request.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["review request"],
                "personalizations" => [
                    [
                        "to" => [["email" => $email]],
                        "subject" => "Welcome to BookMyPlayer!",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $reviewRequestHtml]]
            ]);

    if ($res->status() == 202) {

        DB::table('xx_emails')->insert([
            'email' => $email,
            'type' => $type,
            'source' => $source,
            'creation_date' => now(),
            'ip_address' => request()->ip(),
            'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
            'no_bounce_verified' => 1
        ]);
    }
}

function sendLeadAllocationEmail($sender_email, $name, $sport, $parent_id, $type, $lead_email, $lead_phone, $lead_des, $lead_name, $leadCity)
{

    $isEmailValid = isValidEmail($sender_email);

    if (!$isEmailValid) {
        return;
    }
    $html = str_replace(['{{lead_email}}', '{{lead_phone}}', '{{lead_des}}', '{{lead_name}}', '{{parent_id}}', '{{type}}', '{{date}}', '{{name}}', '{{leadCity}}'], [$lead_email, $lead_phone, $lead_des, $lead_name, $parent_id, $type, date("d/m/Y"), $name, $leadCity], File::get(resource_path('views/email_templates/assign_lead.html')));
    $subject = !empty($lead_name) ? "Verified! $lead_name is looking for Coaching in $sport!" : "Verified! " . $lead_phone . " is looking for $sport Academy to Join";

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["lead assignment"],
                "personalizations" => [
                    [
                        "to" => [["email" => $sender_email]],
                        "subject" => $subject,
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $html]]
            ]);

    // createLog(null, request()->ip(), request()->url(), URL::previous(), getDeviceType(), "welcome email sent",$email);
    DB::table('xx_emails')->insert([
        'email' => $sender_email,
        'type' => "lead-assignment",
        'source' => "",
        'creation_date' => now(),
        'ip_address' => request()->ip(),
        'browser' => strtolower(request()->server('HTTP_USER_AGENT')),
        'no_bounce_verified' => 1
    ]);
}

function sendWBuyServiceRequestEmail($name, $phone, $user_email, $description, $sub)
{
    $emails = ['maheshmhaske241198@gmail.com', 'vaneetg@gmail.com'];
    // vaneetg@gmail.com;
    $type = "buy service request";
    $html = str_replace(['{{name}}', '{{phone}}', '{{email}}', '{{description}}'], [$name, $phone, $user_email, $description], File::get(resource_path('views/email_templates/buy_service_request.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["buy services"],
                "personalizations" => [
                    [
                        "to" => array_map(fn($email) => ["email" => $email], $emails),
                        "subject" => $sub,
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $html]]
            ]);
}

function sendWReportPageIssueEmail($name, $phone, $user_email, $description)
{
    // $emails = ['maheshmhaske241198@gmail.com', 'vaneetg@gmail.com'];
    $emails = ['maheshmhaske241198@gmail.com'];

    $html = str_replace(['{{name}}', '{{phone}}', '{{email}}', '{{description}}'], [$name, $phone, $user_email, $description], File::get(resource_path('views/email_templates/report_page_issue.html')));

    $res = Http::withHeaders([
        'Authorization' => env('SENDGRID_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.sendgrid.com/v3/mail/send', [
                "categories" => ["buy services"],
                "personalizations" => [
                    [
                        "to" => array_map(fn($email) => ["email" => $email], $emails),
                        "subject" => "report page issue request",
                    ]
                ],
                "from" => ["email" => "care@sport.bookmyplayer.com", "name" => "BookMyPlayer"],
                "reply_to" => ["email" => "care@bookmyplayer.com", "name" => "BookMyPlayer Support"],
                "content" => [["type" => "text/html", "value" => $html]]
            ]);
}

function sendNotification($message)
{
    $user_id = session()->get('userId');

    DB::table('bmp_notifications')->insert([
        'user_id' => $user_id,
        'message' => $message,
        'created_at' => now(),
    ]);
}

function authenticate($type_id)
{

    $userId = session()->get('userId');

    if (!$userId) {
        return [false, []];
    }

    $user = get_data_row(null, 'bmp_user', 'id', $userId);
    if (!$user || $user->type_id != $type_id) {
        return [false, []];
    }

    return [true, $user];
}

function authenticateMultiple($type_ids)
{
    $userId = session()->get('userId');

    if (!$userId) {
        return [false, []];
    }

    $user = get_data_row(null, 'bmp_user', 'id', $userId);
    if (!$user || !in_array($user->type_id, (array) $type_ids)) {
        return [false, []];
    }

    return [true, $user];
}

function checkSpamEmail($email)
{
    $email = strtolower(trim($email));
    $spamEmail = DB::table('xx_email_spam')
        ->where('email', $email)
        ->first();

    if ($spamEmail) {
        DB::table('xx_email_spam')
            ->where('id', $spamEmail->id)
            ->increment('views');
    }

    return (bool) $spamEmail;
}

function isNeverBounceVerified($email)
{
    $email = trim($email);
    $apiKey = env('NEVERBOUNCE_API_KEY');
    $xx_emails = DB::table('xx_emails')::where('email', $email)->where('no_bounce_verified', '1')->first();

    if ($xx_emails) {
        return true;
    }

    $response = Http::post("https://api.neverbounce.com/v4/single/check?key=$apiKey&email=" . urlencode($email));

    if ($response->successful()) {
        $result = $response->json()['result'];
        if ($result === 'valid' || $result === 'disposable') {
            return true;
        } else {
            DB::table('xx_email_spam')
                ->insert([
                    'email' => $email,
                    'reason' => "neverbounce:" . $result,
                ]);
            return false;
        }
    } else {
        return false;
    }
}

?>