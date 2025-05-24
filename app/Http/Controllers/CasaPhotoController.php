<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Models\Casa;
use App\Services\PhotoService;

class CasaPhotoController extends Controller
{
    public function __construct(
        protected PhotoService $photoService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Casa $casa)
    {

        $request->validate([
            'photos.*' => 'required|image|max:2048',
        ]);

        foreach ($request->file('url') as $photo) {
            $this->photoService->upload($photo, $casa);
        }

        return;
        #return response()->json(['message' => 'Fotos carregadas com sucesso.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        $id = $photo->id;
        #$photo = $this->photoService->getById($id);
        $this->photoService->delete($photo);

        #return response()->json(['message' => 'Foto removida com sucesso.']);
    }
}
