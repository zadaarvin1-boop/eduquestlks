<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialCompletion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\BadgeAwardService;

class MaterialCompletionController extends Controller
{
    public function store(Material $material): RedirectResponse
    {
        abort_unless($material->is_published, 404);

        MaterialCompletion::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'material_id' => $material->id,
            ],
            [
                'completed_at' => now(),
            ]
        );

        // Periksa dan berikan lencana setelah progres tersimpan.
        app(BadgeAwardService::class)->check(Auth::user());

        return redirect()
            ->route('materials.show', $material->slug)
            ->with('success', 'Materi berhasil ditandai selesai dipelajari.');
    }
}
