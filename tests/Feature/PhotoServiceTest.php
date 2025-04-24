<?php
use App\Services\PhotoService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class, WithFaker::class);

test('pode fazer upload de uma foto', function () {
    Storage::fake('public');
    $photoService = new PhotoService();
    
    $file = UploadedFile::fake()->image('photo.jpg');
    $model = \App\Models\Pessoa::factory()->create();
    
    $photo = $photoService->upload($file, $model);
    
    expect($photo)->toBeInstanceOf(\App\Models\Photo::class);
    expect($photo->getRawOriginal('url'))->not->toBeEmpty();
    expect($photo->imageable_id)->toBe($model->id);
    expect($photo->imageable_type)->toBe(get_class($model));
    
    Storage::disk('public')->assertExists($photo->getRawOriginal('url'));
});

test('pode deletar uma foto', function () {
    Storage::fake('public');
    $photoService = new PhotoService();
    
    $file = UploadedFile::fake()->image('photo.jpg');
    $model = \App\Models\Pessoa::factory()->create();
    $photo = $photoService->upload($file, $model);
    
    $photoService->delete($photo);
    
    expect(\App\Models\Photo::find($photo->id))->toBeNull();
    Storage::disk('public')->assertMissing($photo->getRawOriginal('url'));
});

test('pode obter todas as fotos de um modelo', function () {
    Storage::fake('public');
    $photoService = new PhotoService();
    $model = \App\Models\Pessoa::factory()->create();
    
    $files = [
        UploadedFile::fake()->image('photo1.jpg'),
        UploadedFile::fake()->image('photo2.jpg'),
        UploadedFile::fake()->image('photo3.jpg')
    ];
    
    foreach($files as $file) {
        $photoService->upload($file, $model);
    }
    
    $photos = $photoService->getAllFromModel($model);
    
    expect($photos)->toHaveCount(3);
    expect($photos->first())->toBeInstanceOf(\App\Models\Photo::class);
});
