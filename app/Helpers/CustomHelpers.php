<?php

if (!function_exists('clearTelephone')) {
    /**
     * @param string $telephone
     * @return string
     */
    function clearTelephone(string $telephone) : string
    {
        return preg_replace(['/^\+38/', '/\D+/'], '', $telephone);
    }
}
