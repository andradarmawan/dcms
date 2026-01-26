<?php

namespace App\Helpers;

class FileFormat
{
    public static function fromMime(?string $mime): array
    {
        return match ($mime) {

            // PDF – merah
            'application/pdf' => [
                'label' => 'PDF',
                'gradient' => 'from-red-500 to-rose-600',
                'shadow' => 'shadow-red-500/30',
                'icon' => 'pdf',
                'color' => 'red',
            ],

            // Word – biru
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => [
                'label' => 'DOCX',
                'gradient' => 'from-blue-500 to-indigo-600',
                'shadow' => 'shadow-blue-500/30',
                'icon' => 'word',
                'color' => 'blue',
            ],

            // Excel – hijau
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => [
                'label' => 'XLSX',
                'gradient' => 'from-green-500 to-emerald-600',
                'shadow' => 'shadow-green-500/30',
                'icon' => 'excel',
                'color' => 'green',
            ],

            // PowerPoint – oranye
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => [
                'label' => 'PPTX',
                'gradient' => 'from-orange-600 to-amber-700',
                'shadow' => 'shadow-orange-600/30',
                'icon' => 'ppt',
                'color' => 'orange',
            ],

            default => [
                'label' => 'FILE',
                'gradient' => 'from-gray-500 to-slate-600',
                'shadow' => 'shadow-gray-500/30',
                'icon' => 'file',
                'color' => 'gray',
            ],
        };
    }
}


