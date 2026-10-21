<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'subject' => ['nullable', 'string', 'max:255'],
            'grade' => ['nullable', 'in:7,8,9,10,11,12'],
        ]);

        $query = Material::with('subject')
            ->where('is_published', true);

        if (!empty($filters['subject'])) {
            $query->whereHas('subject', function ($subjectQuery) use ($filters) {
                $subjectQuery->where('slug', $filters['subject']);
            });
        }

        if (!empty($filters['grade'])) {
            $query->where('grade', $filters['grade']);
        }

        if (!empty($filters['q'])) {
            $search = trim($filters['q']);

            if ($search !== '') {
                $query->where(function ($builder) use ($search) {
                    $builder->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%");
                });
            }
        }

        $materials = $query
            ->orderBy('title')
            ->paginate(9)
            ->withQueryString();

        $subjects = Subject::orderBy('name')->get();

        return view('materials.index', compact('materials', 'subjects'));
    }

    public function show(string $slug): View
    {
        $material = Material::with('subject')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('materials.show', compact('material'));
    }
}
