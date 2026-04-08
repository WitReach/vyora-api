<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = \App\Models\CmsPage::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cms_pages,slug',
            'layout' => 'nullable|string|in:default,contained,fluid',
            'content' => 'nullable|json',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_home' => 'boolean',
        ]);

        if ($request->is_home) {
            // Unset other home pages
            \App\Models\CmsPage::where('is_home', true)->update(['is_home' => false]);
        }

        \App\Models\CmsPage::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->slug),
            'layout' => $request->layout ?? 'default',
            'content' => json_decode($request->content, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->has('is_active'),
            'is_home' => $request->has('is_home'),
        ]);

        return redirect()->route('admin.online-store.mnpages.index')->with('success', 'Page created successfully.');
    }

    public function edit(\App\Models\CmsPage $mnpage)
    {
        return view('admin.pages.edit', compact('mnpage'));
    }

    public function design(\App\Models\CmsPage $mnpage)
    {
        $products = \App\Models\Product::select('id', 'name', 'slug')->where('is_active', true)->get();
        return view('admin.pages.design', compact('mnpage', 'products'));
    }

    public function update(Request $request, \App\Models\CmsPage $mnpage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cms_pages,slug,' . $mnpage->id,
            'layout' => 'nullable|string|in:default,contained,fluid',
            'content' => 'nullable|json',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_home' => 'boolean',
        ]);

        if ($request->has('is_home') && $request->is_home) {
            // Unset other home pages
            \App\Models\CmsPage::where('is_home', true)->where('id', '!=', $mnpage->id)->update(['is_home' => false]);
        }

        $mnpage->update([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->slug),
            'layout' => $request->layout ?? 'default',
            'content' => json_decode($request->content, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->has('is_active'),
            'is_home' => $request->has('is_home'),
        ]);

        return redirect()->route('admin.online-store.mnpages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(\App\Models\CmsPage $mnpage)
    {
        if ($mnpage->is_home) {
            return redirect()->back()->with('error', 'Cannot delete the designated Home Page.');
        }
        $mnpage->delete();
        return redirect()->route('admin.online-store.mnpages.index')->with('success', 'Page deleted successfully.');
    }

    public function autoSave(Request $request, \App\Models\CmsPage $mnpage)
    {
        $mnpage->update([
            'draft_content' => json_decode($request->content, true)
        ]);
        return response()->json(['success' => true]);
    }

    public function publish(Request $request, \App\Models\CmsPage $mnpage)
    {
        $content = $request->has('content') ? json_decode($request->content, true) : $mnpage->draft_content;
        $mnpage->update([
            'content' => $content,
            'draft_content' => $content,
        ]);
        return response()->json(['success' => true]);
    }
}
