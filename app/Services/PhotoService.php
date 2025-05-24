<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoService
{
    public function upload(UploadedFile|array $data, ?Model $model = null): Photo
    {
        $file = $data;
        if (!($data instanceof UploadedFile)) {
            if (isset($data['url']) && $data['url'] instanceof UploadedFile) {
                $file = $data['url'];
                $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('photos', $filename, 'public');
                $data['url'] = $path;
            }
        }

        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('photos', $filename, 'public');
        $data = [
            'url' => $path,
            'imageable_id' => $model?->id,
            'imageable_type' => $model ? get_class($model) : null,
        ];

        return Photo::create($data);
    }

    public function update(Photo $photo, array $data): Photo
    {
        if (isset($data['url']) && $data['url'] instanceof UploadedFile) {
            // Remove o arquivo antigo se existir
            if ($photo->url) {
                Storage::disk('public')->delete($photo->getRawOriginal('url'));
            }

            $file = $data['url'];
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('photos', $filename, 'public');
            $data['url'] = $path;
        }

        $photo->update($data);
        return $photo;
    }

    public function delete(Photo $photo): void
    {
        if ($photo->url) {
            Storage::disk('public')->delete($photo->getRawOriginal('url'));
        }
        $photo->delete();
    }

    public function getAllFromModel(Model $model)
    {
        return Photo::where('imageable_id', $model->id)->where('imageable_type', get_class($model))->get();
    }
}
