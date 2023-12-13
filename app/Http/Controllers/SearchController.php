<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Get all Sellers list
     */
    public function searchSeller(Request $req)
    {
        $location   = $req->loc;
        $s          = $req->s;
        $response   = array();
        $cond       = array();
        // $state      = array();

        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $name = [];
            if ($s != null)
                $name = ['business_name' => '%' . preg_replace('/\s+/', '%', $s) . '%'];

            if ($location != null) {
                $location = preg_replace('/\s+/', '%', $location);
                $cond =  [
                    'city'      => '%' .  $location . '%',
                    'area'      => '%' .  $location . '%',
                    'address'   => '%' .  $location . '%',
                    'zip'       => '%' .  $location . '%',
                    'state'     => '%' .  $location . '%',
                    'address'   => '%' .  $location . '%',
                ];
            }
            $status = ['status' => 'Active'];
            $response['result'] = $this->allSellerDataByCond($cond, $name, $status);
            return  response($response, 200);
        } catch (\Throwable $th) {
            $response['error'] = $th->getMessage();
            return  response($response, 500);
        }
    }
    /**
     * Get seller data from by searching and status
     * @param Array $cond
     * @param Array $status
     * @return Object
     */
    public function allSellerDataByCond(array $cond, array $name, array $status,)
    {
        $finalData = array();

        $sellers =   Seller::with('category')->where(function ($query) use ($cond) {
            foreach ($cond as $key => $value) {
                $query->orWhere($key, 'LIKE', $value);
            }
        })
            ->where($status)
            ->where(function ($query) use ($name) {
                foreach ($name as $key => $value) {
                    $query->where($key, 'LIKE', $value);
                }
            })
            ->get()
            ->makeHidden([
                'longitude',
                'latitude',
                'business_email',
                'business_phone',
                'email_verified',
                'phone_verified',
                'document_img_url',
                'verified',
                'status',
                'owner_name',
                'shop_contact',
                'weekly_timing',
                'created_at',
                'updated_at',
                'created_at'
            ]);
        foreach ($sellers as $seller) {
            $seller['weekly_timing'] = json_decode($seller['weekly_timing']);
            array_push($finalData, $seller);
        }
        return $finalData;
    }
}
