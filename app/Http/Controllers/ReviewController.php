<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Hiển thị danh sách đánh giá.
     */
    public function index(request $request)
    {
        $reviews = Review::with(['product', 'customer'])->search($request)->latest()->orderBy('status', 'desc')->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Hiển thị form thêm đánh giá.
     */
    public function show($id)
    {
        $review= Review::with(['product', 'customer'])->findOrFail($id);
        // dd($review->product);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Lưu đánh giá mới vào database.
     */


    /**
     * Hiển thị form chỉnh sửa đánh giá.
     */
    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $products = Product::all();
        return view('admin.reviews.edit', compact('review', 'products'));
    }

    /**
     * Cập nhật đánh giá.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::findOrFail($id);
        $review->update($request->all());

        return redirect()->route('admin.reviews.index')->with('success', 'Cập nhật đánh giá thành công!');
    }

    /**
     * Xóa đánh giá (xóa mềm).
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã bị xóa!');
    }
    public function toggleStatus($id)
    {
        $review = Review::findOrFail($id);
        $review->status = !$review->status; // Chuyển trạng thái
        $review->save();

        return redirect()->route('admin.reviews.index')->with('success', 'Trạng thái đánh giá đã được cập nhật!');
    }
    public function restore($id)
    {
        $review = Review::onlyTrashed()->findOrFail($id);
        $review->restore(); // Khôi phục

        return redirect()->route('admin.reviews.trashed')->with('success', 'Đánh giá đã được khôi phục!');
    }
    public function trashed()
    {
        $reviews = Review::onlyTrashed()->paginate(10);
        return view('admin.reviews.trashed', compact('reviews'));
    }
    public function forceDelete($id)
    {
        $review = Review::onlyTrashed()->findOrFail($id);
        $review->forceDelete(); // Xóa vĩnh viễn khỏi database

        return redirect()->route('admin.reviews.trashed')->with('success', 'Đánh giá đã bị xóa vĩnh viễn!');
    }




}
