<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function attach(Report $report, array $files): void
    {
        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $type = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image';
            $path = $file->store("reports/{$report->id}", 'public');

            $thumbnailPath = null;
            if ($type === 'image') {
                $thumbnailPath = $this->generateThumbnail($file, $report->id);
            }

            $report->media()->create([
                'type' => $type,
                'disk' => 'public',
                'path' => $path,
                'thumbnail_path' => $thumbnailPath,
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }
    }

    private function generateThumbnail(UploadedFile $file, int $reportId): ?string
    {
        // If Intervention Image is available, generate thumbnail
        // For now, use the original as thumbnail (can be enhanced later)
        $thumbPath = "reports/{$reportId}/thumbs";
        $thumbName = 'thumb_' . $file->hashName();

        return $file->storeAs($thumbPath, $thumbName, 'public');
    }

    public function deleteForReport(Report $report): void
    {
        foreach ($report->media as $media) {
            Storage::disk($media->disk)->delete($media->path);
            if ($media->thumbnail_path) {
                Storage::disk($media->disk)->delete($media->thumbnail_path);
            }
            $media->delete();
        }
    }
}
