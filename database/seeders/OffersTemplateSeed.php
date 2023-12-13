<?php

namespace Database\Seeders;

use App\Models\OffersTemplate;
use Illuminate\Database\Seeder;

class OffersTemplateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offers = [
            [
                "offer_code" => "FLAT_X_OFF",
                "offer_title" => "FLAT X OFF",
                "offer_template" => "FLAT {{x}} OFF",
                "offer_type" => json_encode([
                    "%",
                    "Rs"
                ]), 
                "var_count" => 1
            ],
            [
                "offer_code" => "SAVE_UPTO_X",
                "offer_title" => "SAVE UPTO X",
                "offer_template" => "SAVE UPTO {{x}}",
                "offer_type" => json_encode([
                    "%",
                    "Rs"
                ]),
                "var_count" => 1
            ],
            [
                "offer_code" => "UPTO_X_OFF",
                "offer_title" => "UPTO X OFF",
                "offer_template" => "UPTO {{x}} OFF",
                "offer_type" => json_encode([
                    "%",
                    "Rs"
                ]),
                "var_count" => 1
            ],
            [
                "offer_code" => "COMBO_OFF_X",
                "offer_title" => "COMBO OFF X",
                "offer_template" => "COMBO OFF {{x}}",
                "offer_type" => json_encode([
                    "Rs"
                ]),
                "var_count" => 1
            ],
            [
                "offer_code" => "BUY_X_GET_Y",
                "offer_title" => "BUY X GET Y",
                "offer_template" => "BUY {{x}} GET {{y}}",
                "offer_type" => json_encode([]),
                "var_count" => 2
            ],
            [
                "offer_code" => "EXTRA_X_OFF",
                "offer_title" => "EXTRA X OFF",
                "offer_template" => "EXTRA {{x}} OFF",
                "offer_type" => json_encode([
                    "%"
                ]),
                "var_count" => 1
            ],
            [
                "offer_code" => "UNLIMITED_OFFER",
                "offer_title" => "UNLIMITED OFFER",
                "offer_template" => "UNLIMITED OFFER",
                "offer_type" => json_encode([]),
                "var_count" => 0
            ],
            [
                "offer_code" => "SPECIAL_OFFER",
                "offer_title" => "SPECIAL OFFER",
                "offer_template" => "SPECIAL OFFER",
                "offer_type" => json_encode([]),
                "var_count" => 0
            ],
            [
                "offer_code" => "TODAYS_OFFER",
                "offer_title" => "TODAYS OFFER",
                "offer_template" => "TODAYS OFFER",
                "offer_type" => json_encode([]),
                "var_count" => 0
            ]
        ];

        OffersTemplate::insert($offers);
    }
}
