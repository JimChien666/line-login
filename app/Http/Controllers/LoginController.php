<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\http\Services\LineService;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function pageLine(LineService $lineService)
    {
        $url = $lineService->getLoginBaseUrl();
        return view('line')->with('url', $url);
    }

    public function lineLoginCallBack(Request $request, LineService $lineService)
    {
        try {
            $error = $request->input('error', false);
            if ($error) {
                throw new Exception($request->all());
            }
            $code = $request->input('code', '');
            $response = $lineService->getLineToken($code);
            $user_profile = $lineService->getUserProfile($response['access_token']);
            echo "<pre>"; print_r($user_profile); echo "</pre>";
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }
}
