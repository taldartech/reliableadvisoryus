<?php

if (! function_exists('money_inr')) {
    function money_inr(?float $amount): string
    {
        return '₹' . number_format((float) $amount, 2);
    }
}
