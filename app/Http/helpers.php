<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;

if (! function_exists('background'))
{
    function background(?string $status): array
    {
        return match ($status) {
            'canceled' => ['background-color: #d61317', 'color: #fff'],
            'completed' => ['background-color: #456441', 'color: #fff'],
            'part_ordered' => ['background-color: #d9a560', 'color: #fff'],
            'recall' => ['background-color: #187DE4', 'color: #fff'],
            'reschedule' => ['background-color: #54387f', 'color: #fff'],
            default => [],
        };
    }
}

if (! function_exists('badge'))
{
    function badge(int $value, array $words): string
    {
        [$one, $zero] = $words;

        return $value
            ? "<span class='label label-lg label-inline label-light-success'>$one</span>"
            : "<span class='label label-lg label-inline label-light-danger'>$zero</span>";
    }
}

if (! function_exists('format'))
{
    function format(string $datetime, string $format): string
    {
        return Carbon::make($datetime)->format($format);
    }
}

if (! function_exists('image'))
{
    function image(string $folder, ?string $file, int $width = 70): string
    {
        if ($file && file_exists($path = "uploads/{$folder}/{$file}")) {
            return '<img src="' . asset($path) . '" width="' . $width . '">';
        }

        return '<img src="' . asset('img/user.jpg') . '" width="' . $width . '">';
    }
}

if (! function_exists('menu'))
{
    function menu(string $name): bool
    {
        return request()->routeIs("$name.*");
    }
}

if (! function_exists('name'))
{
    function name(bool $short = false): string
    {
        $name = auth('admin')->user()->name;
        $surname = auth('admin')->user()->surname;

        if ($short) {
            $name = str($name)->substr(0, 1)->upper();
            $surname = str($surname)->substr(0, 1)->upper();

            return $name . $surname;
        }

        return $name . ' ' . $surname;
    }
}

if (! function_exists('notify'))
{
    function notify(string $icon, string $title): string
    {
        return <<<JS
                    Swal.fire({
                        icon: '$icon',
                        title: '$title',
                        showConfirmButton: false,
                        timer: 4000,
                    });
                JS;
    }
}

if (! function_exists('sub_menu'))
{
    function sub_menu(string $name): bool
    {
        return request()->routeIs("$name");
    }
}

if (! function_exists('t'))
{
    function t(string $key): string
    {
        return __("api.$key");
    }
}
