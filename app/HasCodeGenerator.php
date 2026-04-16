<?php

namespace App;

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
        return DB::transaction(function () use ($tableName, $columnName, $prefix, $digits, $separator) {

            $lastRecord = DB::table($tableName)
                // Filter hanya yang depannya sama persis dengan prefix + separator
                ->where($columnName, 'like', $prefix . $separator . '%')
                // Urutkan berdasarkan kolom itu sendiri secara DESC
                ->orderBy($columnName, 'desc')
                // Paksa DB buat nahan row ini sampai transaksi selesai
                ->lockForUpdate()
                ->first();

            if (! $lastRecord || empty($lastRecord->$columnName)) {
                $number = 1;
            } else {
                $lastCode = (string) $lastRecord->$columnName;

                // Ambil bagian angkanya saja
                $onlyNumber = Str::after($lastCode, $prefix . $separator);

                // Casting ke int biar aman (Larastan bakal seneng)
                $number = ((int) $onlyNumber) + 1;
            }

            $formattedNumber = str_pad((string) $number, $digits, '0', STR_PAD_LEFT);

            return $prefix . $separator . $formattedNumber;
        });
    }

    public static function generateCodeWithDate(
        string $tableName,
        string $columnName,
        string $prefix,
        int $digits = 6,
        string $separator = ''
    ): string {
        // Jalankan dalam transaksi agar lockForUpdate benar-benar mengunci tabel
        return DB::transaction(function () use ($tableName, $columnName, $prefix, $digits, $separator) {
            $now = now();
            $datePart = $now->format('Ymd');
            $yearPart = $now->format('Y');

            // 1. Cari record terakhir berdasarkan TAHUN (reset tiap tahun)
            // Gunakan lockForUpdate agar proses lain mengantri sampai transaksi ini selesai
            $lastRecord = DB::table($tableName)
                ->where($columnName, 'like', $prefix . $separator . $yearPart . '%')
                ->orderBy($columnName, 'desc')
                ->lockForUpdate()
                ->first();

            if (! $lastRecord || empty($lastRecord->$columnName)) {
                $number = 1;
            } else {
                $lastCode = (string) $lastRecord->$columnName;

                // 2. Ambil angka paling ujung setelah separator terakhir
                // Misal: WO-20240325-000001 -> ambil 000001
                $lastNumber = (int) Str::afterLast($lastCode, $separator);
                $number = $lastNumber + 1;
            }

            $formattedNumber = str_pad((string) $number, $digits, '0', STR_PAD_LEFT);

            // Hasil: PREFIX-20240325-000001
            return $prefix . $separator . $datePart . $separator . $formattedNumber;
        });
    }
}
