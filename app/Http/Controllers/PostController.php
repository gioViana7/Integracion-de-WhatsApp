<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Notifications\PostPublished;

use Facebook\Facebook;

class PostController extends Controller
{
    private $fb;

    /**
     * Create a new controller instance.
     *
     * @param  Facebook $fb
     * @return void
     */
    public function __construct(Facebook $fb)
    {
      $this->fb = $fb;
    }

    private function fbPostApi($params, $uri)
    {
      try {
        // Returns a `FacebookFacebookResponse` object
        $response = $this->fb->post(
          $uri,
          $params
        );
      } catch(FacebookExceptionsFacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(FacebookExceptionsFacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }

      return response()->json(json_decode($response->getGraphNode()->asJson(), true), 200);
    }

    public function publishFbPost(Request $request)
    {
      $params = json_decode($request->getContent(), true);
      return $this->fbPostApi($params, '/me/feed');
    }

    public function uploadFbPhoto(Request $request)
    {
      $params = json_decode($request->getContent(), true);
      return $this->fbPostApi($params, '/me/photos');
    }
}
