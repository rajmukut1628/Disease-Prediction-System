<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MedicalReport;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class SecureMedicalReportFileController extends Controller
{
    public function view(MedicalReport $medicalReport)
    {
        $this->authorizeReportOwner($medicalReport);

        if (!$this->hasAttachedFile($medicalReport)) {
            abort(404, 'No file attached to this report.');
        }

        if (!Storage::disk('local')->exists($medicalReport->file_path)) {
            abort(404, 'File not found.');
        }

        $fileContent = $this->getFileContent($medicalReport);

        return response($fileContent, 200, [
            'Content-Type' => $medicalReport->mime_type ?: 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' . ($medicalReport->original_name ?? 'medical-report') . '"',
            'Cache-Control' => 'private, no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function download(MedicalReport $medicalReport)
    {
        $this->authorizeReportOwner($medicalReport);

        if (!$this->hasAttachedFile($medicalReport)) {
            abort(404, 'No file attached to this report.');
        }

        if (!Storage::disk('local')->exists($medicalReport->file_path)) {
            abort(404, 'File not found.');
        }

        $fileContent = $this->getFileContent($medicalReport);

        return response($fileContent, 200, [
            'Content-Type' => $medicalReport->mime_type ?: 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . ($medicalReport->original_name ?? 'medical-report') . '"',
            'Cache-Control' => 'private, no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    private function getFileContent(MedicalReport $medicalReport): string
    {
        $storedContent = Storage::disk('local')->get($medicalReport->file_path);

        if ($medicalReport->is_encrypted) {
            return base64_decode(Crypt::decryptString($storedContent));
        }

        return $storedContent;
    }

    private function hasAttachedFile(MedicalReport $medicalReport): bool
    {
        return filled($medicalReport->file_path)
            && $medicalReport->file_path !== 'text-only-report';
    }

    private function authorizeReportOwner(MedicalReport $medicalReport): void
    {
        if ((int) $medicalReport->user_id !== (int) auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
    }
}