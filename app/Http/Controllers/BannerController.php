<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $banners = $query->latest()->orderBy('status', 'desc')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $imagePath = $request->file('image')->store('uploads/banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được thêm thành công');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $validateData['image'] = $request->file('image')->store('uploads/banners', 'public');
        } else {
            $validateData['image'] = $banner->image;
        }

        $banner->update($validateData);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được cập nhật');
    }

    public function destroy($id)
    {
        Banner::destroy($id);
        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được xóa');
    }
    public function trashed()
    {
        $banners = Banner::onlyTrashed()->paginate(10);
        return view('admin.banners.trashed', compact('banners'));
    }

    public function restore($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->restore();
        return redirect()->route('admin.banners.trashed')->with('success', 'Banner đã được khôi phục.');
    }

    public function forceDelete($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        Storage::disk('public')->delete($banner->image);
        $banner->forceDelete();
        return redirect()->route('admin.banners.trashed')->with('success', 'Banner đã bị xóa vĩnh viễn.');
    }
}
