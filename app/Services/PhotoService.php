<?php

namespace App\Services;
use App\Models\Photo;

class PhotoService
{
    public function upload(array $data): Photo
    {
        return Photo::create($data);
    }
    public function update(Photo $photo, array $data): Photo
    {
        $photo->update($data);
        return $photo;
    }
    public function delete(Photo $photo): void
    {
        $photo->delete();
        return;
    }
}
