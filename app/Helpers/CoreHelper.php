<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Carbon;

class CoreHelper
{
    /**
     * @param ...$routes
     * @return string
     */
    public static function menuActive(...$routes): string
    {
        return request()->routeIs(...$routes) ? 'active' : '';
    }

    /**
     * @param mixed $value
     * @param array $style
     * @return string
     */
    public static function status(mixed $value, array $style = []): string
    {
        if (empty($style)) {
            $color = ($value === 1 ? "success" : "danger");
            $status = ($value === 1 ? "Active" : "Inactive");
        } else {
            $color = (array_key_exists($value, $style) ? $style[$value] : "light");
            $status = $value;
        }

        return <<<HTML
                <div class="btn-group mb-1">
                    <label class="badge badge-$color btn-sm btn-rounded">
                        $status
                    </label>
                </div>
                HTML;
    }

    /**
     * @param string $url
     * @param false $disabled
     * @return string
     */
    public static function buttonEdit(string $url, bool $disabled = false): string
    {
        $disabled = $disabled === true ? " disabled" : "";

        return <<<HTML
                <a href="$url" title="Edit" class="btn btn-icon btn-sm text-black-50$disabled">
                    <i class="fa fa-edit"></i>
                </a>
                HTML;
    }

    /**
     * @param string $url
     * @param false $disabled
     * @return string
     */
    public static function buttonDelete(string $url, bool $disabled = false): string
    {
        $disabled = $disabled === true ? " disabled" : "";

        return <<<HTML
                <a href="javascript:void(0);" title="Delete" data-delete-confirm="$url" class="btn btn-icon btn-sm text-black-50$disabled">
                   <i class="fa fa-trash"></i>
                </a>
                HTML;
    }

    /**
     * @param string $url
     * @param bool $disabled
     * @param string $target
     * @return string
     */
    public static function buttonView(string $url, bool $disabled = false, string $target = ""): string
    {
        $disabled = $disabled === true ? " disabled" : "";

        return <<<HTML
                <a href="$url" title="View" target="$target" class="btn btn-icon btn-sm text-black-50$disabled">
                    <i class="fa fa-eye"></i>
                </a>
                HTML;
    }

    /**
     * @param string $message
     * @return string
     */
    public static function success(string $message): string
    {
        return <<<HTML
                <div class="alert auto-alert alert-success alert-dismissible show fade rounded-0">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        $message
                    </div>
                </div>
                HTML;
    }

    /**
     * @param string $message
     * @return string
     */
    public static function error(string $message): string
    {
        return <<<HTML
                <div class="alert auto-alert alert-danger alert-dismissible show fade rounded-0">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        $message
                    </div>
                </div>
                HTML;
    }

    /**
     * @param string $message
     * @return string
     */
    public static function warning(string $message): string
    {
        return <<<HTML
                <div class="alert auto-alert alert-warning alert-dismissible show fade rounded-0">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        $message
                    </div>
                </div>
                HTML;
    }

    public static function image(string $url, array|null $style = null): string
    {
        $css = '';
        if (!empty($style)) {
            $cssArray = [];
            foreach ($style as $key => $value) {
                $cssArray[] = "$key: $value;";
            }
            $css = 'style="' . implode(' ', $cssArray) . '"';
        }

        return <<<HTML
                <img src="$url" alt="$url" $css>
                HTML;
    }

    /**
     * @param ?string $filename
     * @param array|null $style
     * @return string
     */
    public static function accountAvatarImage(?string $filename, array|null $style = null): string
    {
        if ($style === null) {
            $style = ['width' => '50px', 'border-radius' => '50%'];
        }

        if (!empty($filename) && file_exists(public_path("storage/uploads/accounts/$filename"))) {
            return CoreHelper::image(asset("storage/uploads/accounts/$filename"), $style);
        }

        return CoreHelper::image(asset('assets/img/avatar/avatar-1.png'), $style);
    }

    public static function getSetting($SETTING_NAME)
    {
       $settings = app('settings');

       try {
           if (array_key_exists($SETTING_NAME, $settings)) {
               return $settings[$SETTING_NAME];
           }

           throw new Exception("Undefined setting name '$SETTING_NAME'.");
       } catch (Exception $exception) {
           return $exception->getMessage();
       }
    }

    /**
     * @param string $timestamp
     * @return string
     */
    public static function timeAgo(string $timestamp): string
    {
        $carbonTimestamp = Carbon::parse($timestamp);
        $timeDifference = $carbonTimestamp->diffInSeconds(now());

        $units = [
            "year" => 31536000,   // seconds in a year
            "month" => 2592000,   // seconds in a month (assuming an average of 30 days)
            "week" => 604800,     // seconds in a week
            "day" => 86400,       // seconds in a day
            "hour" => 3600,       // seconds in an hour
            "minute" => 60,       // seconds in a minute
            "second" => 1         // seconds
        ];

        $unit = "second";

        foreach ($units as $nextUnit => $factor) {
            if ($timeDifference >= $factor) {
                $timeDifference /= $factor;
                $unit = $nextUnit;
                break;
            }
        }

        $timeDifference = round($timeDifference);

        return $timeDifference . " " . $unit . (($timeDifference == 1) ? "" : "s") . " ago";
    }

    /**
     * @param string $text
     * @param int $length
     * @return string
     */
    public static function readMore(string $text, int $length = 255): string
    {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $shortText = substr($text, 0, $length);
            $lastSpace = strrpos($shortText, ' ');
            return substr($shortText, 0, $lastSpace) . '...';
        }
    }

    /**
     * @param int $views
     * @return int|string
     */
    public static function viewCount(int $views): int|string
    {
        if ($views >= 1000000000) {
            return round($views / 1000000000, 1) . 'b';
        } elseif ($views >= 1000000) {
            return round($views / 1000000, 1) . 'm';
        } elseif ($views >= 1000) {
            return round($views / 1000, 1) . 'k';
        } else {
            return $views;
        }
    }
}