<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['group', 'key', 'value'];

    public static function get(string $group, string $key, mixed $default = null): mixed
    {
        $setting = Cache::rememberForever("setting.{$group}.{$key}", function () use ($group, $key) {
            return static::query()->where('group', $group)->where('key', $key)->value('value');
        });

        if ($setting === null) {
            return $default;
        }

        $decoded = json_decode($setting, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $setting;
    }

    public static function set(string $group, string $key, mixed $value): void
    {
        $stored = is_array($value) ? json_encode($value) : (string) $value;

        static::query()->updateOrCreate(
            ['group' => $group, 'key' => $key],
            ['value' => $stored],
        );

        Cache::forget("setting.{$group}.{$key}");
    }
}
