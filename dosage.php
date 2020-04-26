<?php

namespace GammaScout;

class Dosage {

    /**
     * Convert a counts per minute value into a dosage in µSv.
     *
     * @param int|float $cpm
     * @return float
     */
    public static function from($cpm) {
        if ($cpm <= 30) {
            $coefficient = 142.0; // comply with manual
        } elseif ($cpm <= 110) {
            //$coefficient = 138.3;
            $coefficient = -0.04625 * $cpm + 143.3875; // own curve, C(30) = 142, C(110) = 138.3
        } elseif ($cpm <= 388) {
            $coefficient = -0.08339350180505416 * $cpm + 147.56;
        } elseif ($cpm <= 1327) {
            $coefficient = -0.01931769722814499 * $cpm + 122.5;
        } elseif ($cpm <= 4513) {
            $coefficient = -0.004583987441130298 * $cpm + 102.65;
        } else {
            $coefficient = -0.0009384033800311318 * $cpm + 85.706;
        }
        return $cpm / $coefficient;
    }
}
