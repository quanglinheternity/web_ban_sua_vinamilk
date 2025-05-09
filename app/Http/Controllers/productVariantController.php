<?php

namespace App\Http\Controllers;

use App\Models\detailProductVariants;
use App\Models\Product;
use App\Models\productVariants;
use App\Models\sizeBox;
use App\Models\sizeMl;
use Illuminate\Http\Request;

class productVariantController extends Controller
{
    public function index($id) {
        // $product = Product::with([
        //     'productVariants.sizeMl',
        //     'productVariants.detailProductVariants.sizeBox'
        // ])->findOrFail($id);
        // $productVariants = $product->productVariants;
        $product = Product::findOrFail($id);

        // Truy vấn productVariants theo product_id và phân trang
        $productVariants = ProductVariants::with(['sizeMl', 'detailProductVariants.sizeBox'])
            ->where('product_id', $id)->orderBy('created_at', 'desc')->get();
            //
                // dd($productVariants);
        // Kiểm tra dữ liệu
    // foreach ($productVariants as $variant) {
    //     echo '<strong>Biến thể:</strong><br>';
    //     echo 'Size ML: ' . ($variant->sizeMl->size_ml_name ?? 'Không có') . '<br>';

    //     foreach ($variant->detailProductVariants as $detail) {
    //         echo 'Mã biến thể: ' . $detail->variant_code . '<br>';
    //         echo 'Hộp: ' . ($detail->sizeBox->size_box_name ?? 'Không có') . '<br><br>';
    //     }

    //     echo '<hr>';
    // }

        return view('admin.products.indexVariant', compact('product', 'productVariants'));
    }

    public function create($id){
        $product = Product::findOrFail($id);
        $sizeMls = sizeMl::all()->where('status', 1);
        $sizeBoxs = sizeBox::all()->where('status', 1);
        return view('admin.products.createVariant', compact('sizeMls', 'sizeBoxs', 'product'));
    }
    public function store(Request $request, $ProductId){
        // dd($request->all());

        $request->validate([
            'variant_code' => 'required|string|max:55|unique:detail_product_variants,variant_code',
            'variant_name' => 'required|string|max:55',
            'size_ml_id' => 'required|exists:size_mls,id', // Yêu cầu nếu size_box_id không có
            'size_box_id' => 'required|exists:size_boxes,id',// Yêu cầu nếu size_ml_id không có
            'price' => 'required|numeric|min:0',
            'promotional_price' => 'nullable|numeric|lt:price',
            'stock' => 'required|numeric|min:0',
        ],[
            'variant_code.required' => 'Mã biến thể là bắt buộc.',
            'variant_code.string' => 'Mã biến thể phải là một chuỗi.',
            'variant_code.max' => 'Mã biến thể không được vượt quá 55 ký tự.',
            'variant_code.unique' => 'Mã biến thể đã tồn tại.',

            'variant_name.required' => 'Tên biến thể là bắt buộc.',
            'variant_name.string' => 'Tên biến thể phải là một chuỗi.',
            'variant_name.max' => 'Tên biến thể không được vượt quá 55 ký tự.',

            'size_ml_id.required_without' => 'Bạn phải chọn ít nhất một kích thước (Size ML hoặc Size Box).',
            'size_ml_id.exists' => 'Kích thước ML không tồn tại.',

            'size_box_id.required_without' => 'Bạn phải chọn ít nhất một kích thước (Size ML hoặc Size Box).',
            'size_box_id.exists' => 'Kích thước Box không tồn tại.',

            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là một số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',

        ]);
        // dd($request->all());
        $Product=Product::findOrFail($ProductId);
        // Kiểm tra xem biến thể với cùng size đã tồn tại chưa
        $variant= $Product->productVariants()->where('size_ml_id', $request->size_ml_id)->first();
        // dd($variant);
        if($variant){
            //kiểm tra tiếp DetailProductVariant xem có box chx
            $existingDetail=$variant->detailProductVariants()->where('size_box_id', $request->size_box_id)->first();
            if($existingDetail){
                return redirect()->route('admin.products.variants.edit', [$ProductId, $variant->id])
                ->with('warning', 'Biến thể với dung tích và loại hộp này đã tồn tại. Bạn có thể chỉnh sửa tại đây.');
            }
        }
        // Tạo biến thể mới liên kết với sản phẩm
        // dd($Product);
        $productVariant = productVariants::firstOrCreate([
            'product_id' => $ProductId,
            'size_ml_id' => $request->size_ml_id,
        ]);
        // Tạo DetailProductVariant
        detailProductVariants::create([
            'product_variant_id' => $productVariant->id,
            'variant_code' => $request->variant_code,
            'variant_name' => $request->variant_name,
            'price' => $request->price,
            'promotional_price' => $request->promotional_price,
            'stock' => $request->stock,
            'size_box_id' => $request->size_box_id,
        ]);

        return redirect()->route('admin.products.variants', $ProductId)->with('success', 'Thêm biến thể mới');
    }
    public function edit($productId, $variantId)
{
    // Lấy sản phẩm để đảm bảo sản phẩm tồn tại
    $product = Product::findOrFail($productId);

    // Lấy biến thể theo ID và đảm bảo nó thuộc về sản phẩm này
    $variant = $product->product_variants()->where('id', $variantId)->firstOrFail();

    // Trả về view edit và truyền dữ liệu cần thiết
    return view('admin.products.editVariant', [
        'product' => $product,
        'variant' => $variant,
        // Nếu cần, có thể truyền thêm danh sách size_ml và size_box
        'sizeMls' => SizeMl::all()->where('status', 1),
        'sizeBoxes' => SizeBox::all()->where('status', 1),
    ]);
    }
    public function update(Request $request, $productId, $variantId)
{
    $product = Product::findOrFail($productId);
    $variant = $product->product_variants()->where('id', $variantId)->firstOrFail();

    $request->validate([
        'variant_code' => 'required|string|max:55|unique:product_variants,variant_code,' . $variant->id,
        'variant_name' => 'required|string|max:55',
        'size_ml_id' => 'required|exists:size_mls,id',
        'size_box_id' => 'required|exists:size_boxes,id',
        'price' => 'required|numeric|min:0',
        'promotional_price' => 'nullable|numeric|lt:price',
        'stock' => 'required|numeric|min:0',

    ], [
        'variant_code.required' => 'Mã biến thể là bắt buộc.',
        'variant_code.unique' => 'Mã biến thể đã tồn tại.',
        'variant_name.required' => 'Tên biến thể là bắt buộc.',
        'size_ml_id.required' => 'Kích thước ML là bắt buộc.',
        'size_box_id.required' => 'Kích thước Box là bắt buộc.',
        'price.required' => 'Giá là bắt buộc.',
        'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
        'stock.required' => 'Tồn kho là bắt buộc.',
        'stock.min' => 'Tồn kho phải lớn hơn hoặc bằng 0.',
    ]);

    $variant->update([
        'variant_code' => $request->variant_code,
        'variant_name' => $request->variant_name,
        'size_ml_id' => $request->size_ml_id,
        'size_box_id' => $request->size_box_id,
        'price' => $request->price,
        'promotional_price' => $request->promotional_price,
        'stock' => $request->stock,

    ]);

    return redirect()->route('admin.products.variants', $productId)
        ->with('success', 'Cập nhật biến thể thành công');
}
    public function destroy($id){

        $detail_product_variants = detailProductVariants::findOrFail($id);

        $detail_product_variants->delete();

        $variant_id = $detail_product_variants->product_variant_id;
        $product_id = ProductVariants::findOrFail($variant_id)->product_id;

        $existDetailProductVariants = detailProductVariants::where('product_variant_id', $variant_id)->count();
        if($existDetailProductVariants < 1){
            productVariants::findOrFail($variant_id)->delete();
            return redirect()->route('admin.products.variants', $product_id)->with('success', 'Biến hộp và ml thể được xóa');
        }
        // dd($product_id);


        return redirect()->route('admin.products.variants', $product_id)->with('success', 'Biến hộp thể được xóa');
    }
}
