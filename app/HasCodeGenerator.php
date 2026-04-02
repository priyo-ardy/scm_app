<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

trait HasCodeGenerator
{

    public static function generateAutoCode(
        string $tableName,
        string $columnName,
        string $prefix,
        int $digits = 5,
        string $separator = ''
    ): string {
        $lastRecord = DB::table($tableName)->latest('id')->first();

        if (!$lastRecord || empty(($lastRecord->$columnName))) {
            $number = 1;
        } else {
            $lastCode = $lastRecord->$columnName;
            $lastNumber = (int) str_replace($prefix . $separator, '', $lastCode);
            $number = $lastNumber + 1;
        }

        $formattedNumber = str_pad($number, $digits, '0', STR_PAD_LEFT);

        return $prefix . $separator . $formattedNumber;
    }

    public static function generateCodeWithDate(
        string $tableName,
        string $columnName,
        string $prefix,
        int $digits = 6,
        string $separator = ''
    ): string {
        $now = Carbon::now();
        $datePart = $now->format("Ymd");
        $yearPart = $now->format("Y");

        $lastRecord = DB::table($tableName)
            ->whereLike($columnName, "{$prefix}{$separator}{$yearPart}%")
            ->latest('id')
            ->first();

        if (!$lastRecord || empty(($lastRecord->$columnName))) {
            $number = 1;
        } else {
            $segments = explode($separator, $lastRecord->$columnName);
            $lastNumber = (int) end($segments);
            $number = $lastNumber + 1;
        }

        $formattedNumber = str_pad($number, $digits, '0', STR_PAD_LEFT);

        return "{$prefix}{$separator}{$datePart}{$separator}{$formattedNumber}";
    }
}
