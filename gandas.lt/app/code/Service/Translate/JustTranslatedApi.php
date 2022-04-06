<?php

declare(strict_types=1);

namespace Service\Translate;

class JustTranslatedApi
{
    public static function translate(string $text): ?string
    {

        $urlEncodedText = urlencode($text);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://just-translated.p.rapidapi.com/?lang=en-lt&text=" . $urlEncodedText,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: just-translated.p.rapidapi.com",
                "X-RapidAPI-Key: " . TRANSLATE_API_KEY
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if (!$err) {

            $response = json_decode($response);

            return $response->text[0];

        } else {

//            echo "cURL Error #:" . $err;
            return null;

        }

    }
}