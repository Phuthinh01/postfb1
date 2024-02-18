<?php

namespace App\Http\Controllers;

use Redirect;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ToolFB extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getToken(Request $request)
    {
        $client = new Client();
        $url_act = "https://graph.facebook.com/v17.0/me/adaccounts?limit=100&access_token=".$request->token;
        $response = $client->get($url_act);
        $status = $response->getStatusCode(); // Lấy mã trạng thái HTTP
        $body = $response->getBody()->getContents(); // Lấy nội dung của phản hồi
        $data = json_decode($body);
        $act_id = $data->data[0]->id;
        //
        $url_get_page_id = "https://graph.facebook.com/v17.0/me/accounts?fields=name,id,access_token&limit=100&access_token=".$request->token;
        $response = $client->get($url_get_page_id);
        $status = $response->getStatusCode(); // Lấy mã trạng thái HTTP
        $body = $response->getBody()->getContents(); // Lấy nội dung của phản hồi
        $data = json_decode($body, true);
        $data['act_id'] = $act_id;
        $data['token'] = $request->token;
        return view('post',$data);
    }

    /**
     * Display the specified resource.
     */
    public function post(Request $request)
    {
        // dd($request->toArray());
        $client = new Client();
        $urlAdImage = "https://graph.facebook.com/v17.0/".$request->act_id."/adimages?access_token=".$request->token_acc;
        $responseImage = $client->post($urlAdImage, [
            'headers' => ['Content-type' => 'application/json'],
            'json' => ['bytes' => $request->image],
        ]);
        $response_image = json_decode($responseImage->getBody(), true);

        $urlAds = "https://graph.facebook.com/v17.0/" . $request->act_id . "/adcreatives?access_token=" . $request->token_acc;
        $data = [
            "name" => $request->caption,
            "object_story_spec" => [
                "page_id" => $request->page,
                "link_data" => [
                    "call_to_action" => ["type" => "LEARN_MORE"],
                    "link" => $request->url,
                    "name" => " ",
                    "description" => " ",
                    "message" => $request->caption,
                    "picture" => $response_image['images']['bytes']['url'],
                    "caption" => $request->fakelink,
                    "image_hash" => "",
                    "multi_share_end_card" => false,
                    "multi_share_optimized" => false
                ]
            ],
            "degrees_of_freedom_spec" => [
                "creative_features_spec" => [
                    "standard_enhancements" => [
                        "enroll_status" => "OPT_IN"
                    ]
                ]
            ]
        ];
        $response = $client->post($urlAds, [
            'headers' => ['Content-type' => 'application/json'],
            'json' => $data ,
        ]);
        $responseData = json_decode($response->getBody(), true);
        if ($response->getStatusCode() != 200 ) {
            dd($responseData);
        }else{
            $effective_object_story_id = "";
            while ($effective_object_story_id == ""){
                $url_ads = "https://graph.facebook.com/v17.0/". $responseData['id'] ."?fields=name,object_story_id,effective_object_story_id&access_token=".$request->token_acc;
                $response = $client->get($url_ads);
                $body = $response->getBody()->getContents(); // Lấy nội dung của phản hồi
                $data = json_decode($body);
                if (isset($data->effective_object_story_id)) {
                    $effective_object_story_id = $data->effective_object_story_id;
                }else{
                    $effective_object_story_id = "";
                }
                sleep(5);
            }

        }
        $urlTokenPage = "https://graph.facebook.com/v17.0/" . $request->page . "?fields=access_token&access_token=" . $request->token_acc;
        $responseTokenPage = $client->get($urlTokenPage);
        $tokenPage = json_decode($responseTokenPage->getBody(), true)['access_token'];
        $urlAds = "https://graph.facebook.com/" . $effective_object_story_id . "?is_published=true&access_token=" . $tokenPage;
        $responseAds = $client->post($urlAds, [
            'headers' => ['Content-type' => 'application/json'],
            'json' => [] // Empty payload data
        ]);
        if ($responseAds->getStatusCode() != 200 ) {
            dd($responseData);
        }else{
            $notice = "Đăng bài Thành Công!";
            return view('welcome',['notice'=>$notice]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
