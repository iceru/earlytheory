<?php

namespace App\Support;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneNumber
{
    public static function normalize($phone, string $defaultRegion = 'ID'): string
    {
        try {
            $number = self::util()->parse(self::clean((string) $phone), self::region($defaultRegion));

            if (!self::util()->isValidNumber($number)) {
                return '';
            }

            return self::util()->format($number, PhoneNumberFormat::E164);
        } catch (NumberParseException $exception) {
            return '';
        }
    }

    public static function isValid($phone, string $defaultRegion = 'ID'): bool
    {
        try {
            $number = self::util()->parse(self::clean((string) $phone), self::region($defaultRegion));

            return self::util()->isValidNumber($number);
        } catch (NumberParseException $exception) {
            return false;
        }
    }

    public static function lookupCandidates($phone, string $defaultRegion = 'ID'): array
    {
        $raw = self::clean((string) $phone);
        $canonical = self::normalize($raw, $defaultRegion);
        $candidates = [$raw];

        if ($canonical !== '') {
            $number = self::util()->parse($canonical, null);
            $candidates[] = $canonical;
            $candidates[] = ltrim($canonical, '+');
            $candidates[] = preg_replace('/\D+/', '', self::util()->format($number, PhoneNumberFormat::NATIONAL));
        }

        $digits = preg_replace('/\D+/', '', $raw);
        if ($digits !== '') {
            $candidates[] = $digits;
            if (strpos($digits, '00') === 0) {
                $candidates[] = substr($digits, 2);
            }
        }

        return array_values(array_unique(array_filter($candidates)));
    }

    public static function forInput($phone): string
    {
        $phone = trim((string) $phone);

        if ($phone === '' || strpos($phone, '+') === 0) {
            return $phone;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        // Keep legacy Indonesian national numbers national; stored international
        // numbers are digits-only, so restore the leading plus for the picker.
        return strpos($digits, '0') === 0 ? $digits : '+'.$digits;
    }

    private static function clean(string $phone): string
    {
        $phone = trim($phone);
        $digits = preg_replace('/\D+/', '', $phone);

        if (strpos($digits, '00') === 0 && strpos($phone, '+') !== 0) {
            return '+'.substr($digits, 2);
        }

        if (strpos($phone, '+') === 0) {
            return '+'.$digits;
        }

        return $digits;
    }

    private static function util(): PhoneNumberUtil
    {
        return PhoneNumberUtil::getInstance();
    }

    private static function region(string $region): string
    {
        $region = strtoupper($region);

        return preg_match('/^[A-Z]{2}$/', $region)
            && in_array($region, self::util()->getSupportedRegions(), true)
                ? $region
                : 'ID';
    }
}
