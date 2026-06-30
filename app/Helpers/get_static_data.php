<?php
// app/Helpers/get_static_data.php

if (!function_exists('get_static_data')) {

    function get_static_data($file = null, $sport_id = null, $count = null)
    {
        $path = app_path($file);
        $jsonContent = file_get_contents($path);
        $faqs = json_decode($jsonContent, true);

        if ($sport_id === null) {
            $result = $faqs;
        } else {
            $result = array_filter($faqs, function ($faq) use ($sport_id) {
                return isset($faq['sport_id']) && $faq['sport_id'] == $sport_id;
            });
            $result = array_values($result);
        }

        if ($count !== null && is_numeric($count) && $count > 0) {
            $result = array_slice($result, 0, $count);
        }

        return $result;
    }

    function get_static_data_location_about($file = null, $id = null)
    {
        $path = app_path($file);
        $jsonContent = file_get_contents($path);
        $locations = json_decode($jsonContent, true);

        $result = array_filter($locations, function ($location) use ($id) {
            return isset($location['id']) && $location['id'] == $id;
        });

        $result = array_map(function ($location) {
            return [
                'description' => $location['description'] ?? null,
                'locality_name' => $location['locality_name'] ?? null,
                'photos' => $location['photos'] ?? null,
                'pricing' => $location['pricing'] ?? null,

            ];
        }, array_values($result));

        return $result;
    }

    function get_review_highlight($file = null, $id = null, $rating = null)
    {
        $path = app_path($file);
        $jsonContent = file_get_contents($path);
        $locations = json_decode($jsonContent, true);

        $result = array_filter($locations, function ($location) use ($id) {
            return isset($location['id']) && $location['id'] == $id;
        });

        $result = array_map(function ($location) use ($rating) {
            $highlight = $location['highlight'][$rating] ?? null;
            return [
                'sport_id' => $location['id'],
                'sport' => $location['sport'] ?? [],
                'criteria' => $location['criteria'] ?? [],
                'rating' => $rating,
                'highlight' => $highlight,

            ];
        }, array_values($result));

        return $result;
    }



}
?>