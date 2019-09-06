<?php


namespace execut\files;


class FormatConverter
{
    const FORMAT_JPEG = 'jpg';
    const FORMAT_JPEG2000 = 'jp2';
    const FORMAT_WEBP = 'webp';
    const FORMAT_JPEG_XR = 'jxr';
    const STANDARD_FORMATS = [
        FormatConverter::FORMAT_JPEG2000 => [
            'mimeType' => 'image/jp2',
        ],
        FormatConverter::FORMAT_JPEG_XR => [
            'mimeType' => 'image/jxr',
        ],
        FormatConverter::FORMAT_WEBP => [
            'mimeType' => 'image/webp',
        ],
    ];
}