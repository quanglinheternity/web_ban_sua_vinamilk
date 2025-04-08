<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        // Tìm kiếm theo tiêu đề
        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $posts = $query->latest()->orderBy('status', 'desc')->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'  => 'required|boolean',
        ]);

        // Xử lý ảnh đại diện nếu có
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'  => 'required|boolean',
        ]);

        // Nếu có ảnh mới, xóa ảnh cũ và lưu ảnh mới
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validatedData['image'] = $request->file('image')->store('posts', 'public');
        } else {
            $validatedData['image'] = $post->image;
        }

        $post->update($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được cập nhật!');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(string $id)
    {
        $post=Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được xóa!');
    }
     /**
     * Hiển thị danh sách bài viết đã xóa mềm
     */
    public function trashed()
    {
        $trashedPosts = Post::onlyTrashed()->paginate(10);
        return view('admin.posts.trashed', compact('trashedPosts'));
    }

    /**
     * Khôi phục bài viết đã xóa mềm
     */
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('admin.posts.trashed')->with('success', 'Bài viết đã được khôi phục!');
    }

    /**
     * Xóa vĩnh viễn bài viết
     */
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        // Xóa ảnh nếu có
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->forceDelete();

        return redirect()->route('admin.posts.trashed')->with('success', 'Bài viết đã bị xóa vĩnh viễn!');
    }
}
