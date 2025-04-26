<?php

return [
    /**
     * The driver to use for QR code generation.
     * Supported drivers are 'gd' (GD Library) and 'imagick' (Imagick Extension).
     * GD is the default driver and works well for most use cases.
     */
    'driver' => env('QR_CODE_DRIVER', 'gd'), // 'gd' or 'imagick'

    /**
     * The size of the generated QR code.
     * A larger value will produce a larger QR code.
     */
    'size' => 300, // Default size of the QR code (in pixels)

    /**
     * The margin (whitespace) around the QR code.
     * This controls how much space appears around the QR code.
     */
    'margin' => 10, // Default margin size (in pixels)

    /**
     * The error correction level to use for the QR code.
     * Options are: 'low', 'medium', 'quartile', 'high'.
     * Higher error correction levels will make the QR code larger.
     */
    'error_correction' => 'high', // 'low', 'medium', 'quartile', 'high'

    /**
     * The foreground color of the QR code.
     * This can be specified using RGB values, or you can use a hexadecimal color code.
     * Default is black ([0, 0, 0]).
     */
    'foreground_color' => [0, 0, 0], // Default color is black (RGB)

    /**
     * The background color of the QR code.
     * This can be specified using RGB values, or you can use a hexadecimal color code.
     * Default is white ([255, 255, 255]).
     */
    'background_color' => [255, 255, 255], // Default color is white (RGB)

    /**
     * The label that appears under the QR code.
     * You can set a custom label to be shown under the QR code.
     */
    'label' => null, // You can set a string to display a label beneath the QR code

    /**
     * The font size of the label text.
     * If no label is set, this will have no effect.
     * Default is 16.
     */
    'label_font_size' => 16, // Default label font size (in pixels)

    /**
     * The encoding of the QR code.
     * You can specify the encoding of the QR code content. Default is 'UTF-8'.
     */
    'encoding' => 'UTF-8', // Encoding for the QR code content

    /**
     * The level of the QR code.
     * The level specifies the level of encoding. Options: L, M, Q, H.
     * L = Lowest, H = Highest.
     */
    'level' => 'H', // Error correction level: 'L', 'M', 'Q', 'H'

    /**
     * The image format for the generated QR code.
     * You can choose between 'png', 'jpg', or 'svg'.
     */
    'image_type' => 'png', // Supported formats: 'png', 'jpg', 'svg'

    /**
     * The logo to be embedded in the center of the QR code (optional).
     * Provide a path to the image you want to embed.
     */
    'logo' => null, // Optionally specify the path to an image file to embed in the center

    /**
     * The logo width, this is the size of the logo when embedding.
     * Default is 0 which means the logo will not be resized.
     */
    'logo_width' => 50, // Default is 50px

    /**
     * Whether to encode the QR code data as base64.
     * This option can be useful when you want to output the QR code in an HTML image tag.
     */
    'base64' => true, // true or false for base64 encoding
];
