<?php

namespace App\Services\Vimeo;

use Vimeo\Vimeo;

class VimeoSlotService
{

    private Vimeo $vimeo;

    public function __construct()
    {
        $this->vimeo = new Vimeo(
            env('VIMEO_CLIENT'),
            env('VIMEO_SECRET'),
            env('VIMEO_ACCESS')
        );
    }

    public function createSlot(int $orderId, int $fileSize, string $nameVideo)
    {
        $vimeoOptions = self::getOptionInsertVideo($fileSize, "{$nameVideo} #{$orderId}");
        return $this->vimeo->request('/me/videos', $vimeoOptions, 'POST');
    }



    static public function getOptionInsertVideo($fileSize, $nameVideoTo)
    {
        return array(
            'upload' => [
                'approach' => 'tus',
                'size' => $fileSize,
            ],
            'privacy' => [
                "view" => "disable",
                "download" => true,
            ],
            'name' => "Video para {$nameVideoTo}",
            'embed' => [
                'color' => '#ef00b8',
                'buttons' => [
                    'embed' => false,
                    'fullscreen' => true,
                    'hd' => false,
                    'like' => false,
                    'scaling' => false,
                    'share' => false,
                    'watchlater' => false,
                ],
                'logos' => [
                    'vimeo' => false
                ],
                'playbar' => false,
                'privacy' => [
                    'download' => true
                ],
                'title' => [
                    'name' => 'hide',
                    'owner' => 'hide',
                    'portrait' => 'hide'
                ],
                'volume' => false,
                'uri' => "/presets/120906813",
                "interactions"=> [
                    "buy" => [
                        "download" => "available"
                    ]
                ]
            ]
        );
    }
}
