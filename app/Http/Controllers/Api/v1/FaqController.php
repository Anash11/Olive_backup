<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function getFaq()
    {
        try{
            $faqs = Faq::where('status', 1)->get();
            return response()->json($faqs, 200);
            
        }catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
}
