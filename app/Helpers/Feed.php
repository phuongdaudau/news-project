<?php

namespace App\Helpers;

use Throwable;

class Feed
{
    public static function read($itemsRss)
    {
        $result = [];
        foreach ($itemsRss as $item) {
            if (Feed::checkSourceLink($item['source'], $item['link'])) {
                switch ($item['source']) {
                    case 'vnexpress':
                        $data = Feed::readRssVNE($item['link']);
                        $result = array_merge_recursive($result, $data);
                        break;
                    case 'tuoitre':
                        $data = Feed::readRssTT($item['link']);
                        $result = array_merge_recursive($result, $data);
                        break;
                }
            }
        }
        return $result;
    }
    public static function checkSourceLink($source, $link)
    {
        $sourceFromLink = explode('.', parse_url($link, PHP_URL_HOST))[0];
        return ($source == $sourceFromLink);
    }
    public static function readRssVNE($link)
    {
        try {
            $data = simplexml_load_file($link, "SimpleXMLElement", LIBXML_NOCDATA);
            $data = json_encode($data);
            $data = json_decode($data, TRUE);
            $data = $data['channel']['item'];

            foreach ($data as $key => $value) {
                unset($data[$key]['guid']);
                $tmp1 = [];
                $pattern    = '#src="(.*)".*/br>(.*)\.#imsU';
                preg_match($pattern, $value['description'], $tmp1);
                $data[$key]['thumb'] = $tmp1[1] ?? '';
                $data[$key]['description'] = $tmp1[2] ?? $value['description'];
            }
            return $data;
        } catch (\Throwable $th) {
            return [];
        }
    }
    public static function readRssTT($link)
    {
        try {
            $data = simplexml_load_file($link, "SimpleXMLElement", LIBXML_NOCDATA);
            $data = json_encode($data);
            $data = json_decode($data, TRUE);
            $data = $data['channel']['item'];

            foreach ($data as $key => $value) {
                unset($data[$key]['guid']);
                $tmp1 = [];
                $pattern    = '#src="(.*)".*/a>(.*)\.#imsU';
                preg_match($pattern, $value['description'], $tmp1);
                $data[$key]['thumb'] = $tmp1[1] ?? '';
                $data[$key]['description'] = $tmp1[2] ?? $value['description'];
            }
            return $data;
        } catch (\Throwable $th) {
            return [];
        }
    }
    public static function getGold()
    {
        $context = stream_context_create(['ssl' => [
            'verify_peer' => false,
            "verify_peer_name" => false
        ]]);

        libxml_set_streams_context($context);

        $link = 'https://www.sjc.com.vn/xml/tygiavang.xml';
        $data = simplexml_load_file($link, "SimpleXMLElement", LIBXML_NOCDATA);
        $data = json_encode($data);
        $data = json_decode($data, TRUE);
        $data = $data['ratelist']['city']['0']['item'];
        $data = array_column($data, '@attributes');
        return $data;
    }
    public static function getCoin()
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        $parameters = [
            'start' => '1',
            'limit' => '10',
            'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 2b7bb2ff-d158-4398-ae08-41e2eb4e5d62'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers 
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $data = json_decode($response, TRUE); // print json decoded response
        curl_close($curl); // Close request

        $data = $data['data'];
        $result = [];
        foreach ($data as $key => $item) {
            $result[$key]['name'] = $item['name'];
            $result[$key]['price'] = $item['quote']['USD']['price'];
            $result[$key]['percent_change_24h'] = $item['quote']['USD']['percent_change_24h'];
        }
        return $result;
    }
}
