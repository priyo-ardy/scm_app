<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait HasCodeGenerator
{

    public static function generateAutoCode(
        string $tableName,
        string $columnName,
        string $prefix,
        int $digits = 5,
        string $separator = ''
    ): string {
        // $lastRecord = DB::table($tableName)->latest('id')->first();
        $lastRecord = DB::table($tableName)
            ->where($columnName, 'like', $prefix . $separator . '%')
            ->orderBy($columnName, 'desc')
            ->lockForUpdate()
            ->first();

        if (!$lastRecord || empty(($lastRecord->$columnName))) {
            $number = 1;
        } else {
            $lastCode = $lastRecord->$columnName;
            $lastNumber = (int) Str::after($lastCode, $prefix . $separator);
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
        $now = now(); // Pakai helper now() lebih simpel
        $datePart = $now->format("Ymd");
        $yearPart = $now->format("Y");

        // 1. Cari record terakhir berdasarkan TAHUN saja agar sequence
        // tetap berlanjut walau ganti hari, tapi reset saat ganti tahun.
        // Atau kalau mau reset tiap hari, ganti $yearPart jadi $datePart.
        $lastRecord = DB::table($tableName)
            ->where($columnName, 'like', $prefix . $separator . $yearPart . '%')
            ->orderBy($columnName, 'desc') // Lebih akurat cari angka terbesar
            ->lockForUpdate()
            ->first();

        if (!$lastRecord || empty(($lastRecord->$columnName))) {
            $number = 1;
        } else {
            $lastCode = $lastRecord->$columnName;

            // 2. Ambil angka paling ujung setelah separator terakhir
            // Misal: WO-20240325-000001 -> ambil 000001
            $lastNumber = (int) Str::afterLast($lastCode, $separator);
            $number = $lastNumber + 1;
        }

        $formattedNumber = str_pad((string)$number, $digits, '0', STR_PAD_LEFT);

        // Hasil: PREFIX-20240325-000001
        return $prefix . $separator . $datePart . $separator . $formattedNumber;
    }
}
