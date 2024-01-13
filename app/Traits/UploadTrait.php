<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

trait UploadTrait
{
    public function delete(string $folder, ?string $file): void
    {
        if (! $file) {
            return;
        }

        $this->deleteFile($folder, $file);
    }

    public function multiDelete(string $folder, array $files): void
    {
        foreach ($files as $file) {
            $this->delete($folder, $file);
        }
    }

    public function multiUpload(string $folder, array|UploadedFile $files): array
    {
        $names = [];

        foreach ($files as $file) {
            $names[] = ['image' => $this->upload($folder, $file)];
        }

        return $names;
    }

    public function upload(string $folder, UploadedFile $file): string
    {
        $this->makeFolder($folder);

        return $this->uploadFile($folder, $file);
    }

    private function deleteFile(string $folder, string $file): void
    {
        if (! File::exists($path = public_path("uploads/$folder/$file"))) {
            return;
        }

        File::delete($path);
    }

    private function makeFolder(string $folder): void
    {
        if (File::exists($path = public_path("uploads/$folder"))) {
            return;
        }

        File::makeDirectory($path);
    }

    private function uploadFile(string $folder, UploadedFile $file): string
    {
        $name = uniqid() . '.' . str($file->extension())->lower();

        $file->move("uploads/{$folder}", $name);

        return $name;
    }
}
