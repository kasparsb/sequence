<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use \App\Models\NumberFormat;

use Auth;
use Numbers;

class NumberFormatsController extends Controller {
    
    /**
     * Atgriežam numuru formātus
     */
    public function index() {
        // Numuru formātus vienmēr ņemam pēc ielogotā api key
        // Ielogotajai api key ir piesaistīts lietotājs

        return NumberFormat::where('user_id', '=', Auth::user()->user->id)->get();
    }

    public function generate(int $numberFormatId, int $count=1) {
        
        $numberFormat = NumberFormat::where('user_id', '=', Auth::user()->user->id)
            ->where('id', '=', $numberFormatId)
            ->first();

        $r = [];
        for ($i = 0; $i < $count; $i++) {
            $r[] = Numbers::createByApiKey($numberFormat, Auth::user());
        }
        return $r;
    }
}
