<?php

use App\Services\PessoaService;
use App\Services\PhotoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;


uses(RefreshDatabase::class, WithFaker::class);

test('it can create a pessoa with photo', function () {
    $pessoaService = new PessoaService();
    $photoService = new PhotoService();
    
    $data = [
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ];

    $pessoa = $pessoaService->create($data);

    // Create fake image file
    $file = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg');
    
    $photo = $photoService->upload($file, $pessoa);

    expect($pessoa)->toBeInstanceOf(\App\Models\Pessoa::class);
    expect($pessoa->nome)->toEqual($data['nome']); 
    expect($pessoa->telefone)->toEqual($data['telefone']);
    expect($pessoa->photos)->toHaveCount(1);
    expect($photo)->toBeInstanceOf(\App\Models\Photo::class);
});

test('it can update a pessoa with photo', function () {
    $pessoaService = new PessoaService();
    $photoService = new PhotoService();
    
    $pessoa = \App\Models\Pessoa::factory()->create();
    
    // Create initial photo
    $initialFile = \Illuminate\Http\UploadedFile::fake()->image('initial.jpg');
    $photoService->upload($initialFile, $pessoa);

    $data = [
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ];

    $updatedPessoa = $pessoaService->update($pessoa, $data);

    // Add new photo
    $newFile = \Illuminate\Http\UploadedFile::fake()->image('new.jpg');
    $newPhoto = $photoService->upload($newFile, $updatedPessoa);

    expect($updatedPessoa)->toBeInstanceOf(\App\Models\Pessoa::class);
    expect($updatedPessoa->nome)->toEqual($data['nome']);
    expect($updatedPessoa->telefone)->toEqual($data['telefone']);
    expect($updatedPessoa->photos)->toHaveCount(2);
});

test('it can delete a pessoa and associated photos', function () {
    $pessoaService = new PessoaService();
    $photoService = new PhotoService();
    
    $pessoa = \App\Models\Pessoa::factory()->create();
    
    // Add photo before deletion
    $file = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg');
    $photoService->upload($file, $pessoa);

    $pessoaService->delete($pessoa);

    expect(\App\Models\Pessoa::find($pessoa->id))->toBeNull();
    expect(\App\Models\Photo::where('photoable_id', $pessoa->id)->count())->toBe(0);
});

test('it can get all pessoas with photos', function () {
    $pessoaService = new PessoaService();
    $photoService = new PhotoService();
    
    $pessoas = \App\Models\Pessoa::factory()->count(5)->create();
    
    // Add photo to each pessoa
    foreach($pessoas as $pessoa) {
        $file = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg');
        $photoService->upload($file, $pessoa);
    }

    $allPessoas = $pessoaService->getAll();

    expect($allPessoas)->toHaveCount(5);
    foreach($allPessoas as $pessoa) {
        expect($pessoa->photos)->toHaveCount(1);
    }
});

test('it can get a pessoa by id with photos', function () {
    $pessoaService = new PessoaService();
    $photoService = new PhotoService();
    
    $pessoa = \App\Models\Pessoa::factory()->create();
    
    $file = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg');
    $photoService->upload($file, $pessoa);

    $foundPessoa = $pessoaService->getById($pessoa->id);

    expect($foundPessoa)->toBeInstanceOf(\App\Models\Pessoa::class);
    expect($foundPessoa->id)->toEqual($pessoa->id);
    expect($foundPessoa->photos)->toHaveCount(1);
});


test('it can create a pessoa', function () {
    $pessoaService = new PessoaService();
    $data = [
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ];

    $pessoa = $pessoaService->create($data);

    expect($pessoa)->toBeInstanceOf(\App\Models\Pessoa::class);
    expect($pessoa->nome)->toEqual($data['nome']);
    expect($pessoa->telefone)->toEqual($data['telefone']);
});
test('it can update a pessoa', function () {
    $pessoaService = new PessoaService();
    $pessoa = \App\Models\Pessoa::factory()->create();
    $data = [
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ];

    $updatedPessoa = $pessoaService->update($pessoa, $data);

    expect($updatedPessoa)->toBeInstanceOf(\App\Models\Pessoa::class);
    expect($updatedPessoa->nome)->toEqual($data['nome']);
    expect($updatedPessoa->telefone)->toEqual($data['telefone']);
});
test('it can delete a pessoa', function () {
    $pessoaService = new PessoaService();
    $pessoa = \App\Models\Pessoa::factory()->create();

    $pessoaService->delete($pessoa);

    expect(\App\Models\Pessoa::find($pessoa->id))->toBeNull();
});
test('it can get all pessoas', function () {
    $pessoaService = new PessoaService();
    \App\Models\Pessoa::factory()->count(5)->create();

    $pessoas = $pessoaService->getAll();

    expect($pessoas)->toHaveCount(5);
});
test('it can get a pessoa by id', function () {
    $pessoaService = new PessoaService();
    $pessoa = \App\Models\Pessoa::factory()->create();

    $foundPessoa = $pessoaService->getById($pessoa->id);

    expect($foundPessoa)->toBeInstanceOf(\App\Models\Pessoa::class);
    expect($foundPessoa->id)->toEqual($pessoa->id);
});
test('it can search pessoas by nome or telefone', function () {
    $pessoaService = new PessoaService();
    $pessoa1 = \App\Models\Pessoa::factory()->create(['nome' => 'John Doe']);
    $pessoa2 = \App\Models\Pessoa::factory()->create(['telefone' => '1234567890']);

    $result = $pessoaService->search('John');

    expect($result)->toHaveCount(1);
    expect($result->first()->id)->toEqual($pessoa1->id);

    $result = $pessoaService->search('1234567890');

    expect($result)->toHaveCount(1);
    expect($result->first()->id)->toEqual($pessoa2->id);
});
test('it returns empty collection when no pessoas match search', function () {
    $pessoaService = new PessoaService();
    \App\Models\Pessoa::factory()->create(['nome' => 'John Doe']);

    $result = $pessoaService->search('Jane');

    expect($result)->toHaveCount(0);
});
test('it returns empty collection when no pessoas match search by telefone', function () {
    $pessoaService = new PessoaService();
    \App\Models\Pessoa::factory()->create(['telefone' => '1234567890']);

    $result = $pessoaService->search('0987654321');

    expect($result)->toHaveCount(0);
});
test('it returns empty collection when no pessoas match search by nome and telefone', function () {
    $pessoaService = new PessoaService();
    \App\Models\Pessoa::factory()->create(['nome' => 'John Doe', 'telefone' => '1234567890']);

    $result = $pessoaService->search('Jane Doe');

    expect($result)->toHaveCount(0);
});

