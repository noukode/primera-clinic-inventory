<?php

namespace App;

use Illuminate\Support\Facades\Storage;

class Helper{
    public static function imgToBase64($path)
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        return 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($path));
    }
}
