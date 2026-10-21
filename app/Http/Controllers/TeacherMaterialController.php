<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeacherMaterialController extends Controller
{
    public function index(Request $request): View
    {
        $query = Material::with('subject')->latest();

        // Guru hanya melihat materi miliknya.
        // Admin dapat melihat semua materi.
        if ($request->user()->role !== 'admin') {
            $query->where('created_by', $request->user()->id);
        }

        $materials = $query->paginate(10);

        return view('teacher.materials.index', compact('materials'));
    }

    public function create(): View
    {
        return view('teacher.materials.create', [
            'material' => new Material(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateMaterial($request);

        $baseSlug = Str::slug($data['title']) ?: 'materi';
        $slug = $baseSlug;
        $number = 2;

        while (Material::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $number;
            $number++;
        }

        Material::create([
            'subject_id' => $data['subject_id'],
            'created_by' => $request->user()->id,
            'grade' => $data['grade'],
            'title' => $data['title'],
            'slug' => $slug,
            'summary' => $data['summary'] ?? null,
            'content' => $data['content'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()
            ->route('teacher.materials.index')
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(
        Request $request,
        Material $material
    ): View {
        $this->authorizeMaterial($request, $material);

        return view('teacher.materials.edit', [
            'material' => $material,
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function update(
        Request $request,
        Material $material
    ): RedirectResponse {
        $this->authorizeMaterial($request, $material);

        $data = $this->validateMaterial($request);

        $material->update([
            'subject_id' => $data['subject_id'],
            'grade' => $data['grade'],
            'title' => $data['title'],
            'summary' => $data['summary'] ?? null,
            'content' => $data['content'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()
            ->route('teacher.materials.index')
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(
        Request $request,
        Material $material
    ): RedirectResponse {
        $this->authorizeMaterial($request, $material);

        $material->delete();

        return redirect()
            ->route('teacher.materials.index')
            ->with('success', 'Materi berhasil dihapus.');
    }

    private function validateMaterial(Request $request): array
    {
        return $request->validate([
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'grade' => ['required', 'in:7,8,9,10,11,12'],
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
        ]);
    }

    private function authorizeMaterial(
        Request $request,
        Material $material
    ): void {
        $isAdmin = $request->user()->role === 'admin';
        $isOwner = (int) $material->created_by
            === (int) $request->user()->id;

        abort_unless(
            $isAdmin || $isOwner,
            403,
            'Kamu tidak memiliki akses untuk mengelola materi ini.'
        );
    }
}
