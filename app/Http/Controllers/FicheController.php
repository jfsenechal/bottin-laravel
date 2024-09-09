<?php

namespace App\Http\Controllers;

use App\Models\Fiche;
use App\Models\Image;
use Illuminate\Http\Request;

class FicheController extends Controller
{
    public function store(Request $request)
    {
        dd($request);
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'images' => 'required|array',  // Multiple images
            'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',  // Ensure they are valid image files
        ]);

        // Create a new Fiche record
        $fiche = Fiche::create([
            'name' => $validatedData['name'],
        ]);

        // Loop through uploaded images and save them
        foreach ($validatedData['images'] as $imageFile) {
            // Save the image to the disk
            $imagePath = $imageFile->store('uploads/images', 'public');

            // Save the image in the database, linking it to the fiche
            Image::create([
                'fiche_id' => $fiche->id,  // Link image to fiche
                'main_image' => false,      // Default, can set based on logic if needed
                'path' => $imagePath,       // Assuming 'path' field exists in Image model for image path
            ]);
        }

        // Optional: You can set one of the images as the main image based on custom logic
        // Example: Set the first uploaded image as the main image
        if ($fiche->images()->exists()) {
            $fiche->images()->first()->update(['main_image' => true]);
        }

        return redirect()->route('fiches.index')->with('success', 'Fiche created successfully');
    }
}
