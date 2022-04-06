<?php

declare(strict_types=1);

namespace Service\GetNewsFromApi;

use Model\News;
use Service\Translate\JustTranslatedApi;

class WebitNews
{
    public function exec(): void
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://webit-news-search.p.rapidapi.com/trending?language=en",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: webit-news-search.p.rapidapi.com",
                "X-RapidAPI-Key: " . WEBIT_API_KEY
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {

            echo "cURL Error #:" . $err;

        } else {

            $response = json_decode($response);
            $newsFromWebit = $response->data->results;

            foreach ($newsFromWebit as $item) {

                if (
                    isset($item->title) &&
                    isset($item->description) &&
                    isset($item->image)
                ) {

                    $translatedTitle = JustTranslatedApi::translate($item->title);
                    $translatedContent = JustTranslatedApi::translate($item->description);

                    if ($translatedTitle != null && $translatedContent != null) {

                        $news = new News();
                        $news->setTitle($translatedTitle);
                        $news->setContent($translatedContent);
                        $news->setImage($item->image);
                        $news->setViews(0);
                        $news->setAuthorId(1);
                        $news->setActive(1);
                        $news->setSlug(strtolower(trim(str_replace([':', ' ', ',', '.', '"', "'"], '-', $item->title))));
                        $news->save();

                    }
                }

            }

        }

    }
}