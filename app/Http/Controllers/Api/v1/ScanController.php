<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\OfferScan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function all()
    {
        if (!auth()->user()) {
            $response['status'] = false;
            $response['message'] = 'Unautherized Access';
            return response($response, 401);
        }
        $scanOffer = OfferScan::with('user', 'seller.category', 'offer')->where(['FK_user_id' => auth()->user()->id])->get();
        $count = $scanOffer->count();
        $response['status'] = true;
        $response['message'] = 'All Scans Found';
        $response['data'] = $scanOffer;
        $response['count'] = $count;
        return response()->json($response, 200);

    }
}
