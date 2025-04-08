<?php
return [
    'required' => ':attribute không được để trống.',
    'string' => ':attribute phải là chuỗi.',
    'max' => [
        'string' => ':attribute không được vượt quá :max ký tự.',
        'numeric' => ':attribute không được lớn hơn :max.',
    ],
    'min' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
        'integer' => ':attribute phải lớn hơn hoặc bằng :min.',
    ],
    'unique' => ':attribute đã tồn tại, vui lòng chọn giá trị khác.',
    'numeric' => ':attribute phải là số.',
    'integer' => ':attribute phải là số nguyên.',
    'exists' => ':attribute không hợp lệ.',
    'lt' => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file' => ':attribute phải nhỏ hơn :value kilobytes.',
        'string' => ':attribute phải ít hơn :value ký tự.',
        'array' => ':attribute phải có ít hơn :value phần tử.',
     ],
    'digits_between' => ':attribute phải có từ :min đến :max chữ số.',
    'date' => ':attribute phải là ngày hợp lệ.',
    'boolean' => ':attribute phải là đúng hoặc sai.',
    'image' => ':attribute phải là ảnh.',
    'mimes' => ':attribute phải có định dạng: :values.',
    'max.file' => ':attribute không được lớn hơn :max KB.',
    'email' => ':attribute phải là địa chỉ email hợp lệ.',
    'regex' => ':attribute không đúng định dạng.',

    // Tùy chỉnh tên thuộc tính để hiển thị tiếng Việt
    'attributes' => [
        'ma_san_pham' => 'Mã sản phẩm',
        'ten_san_pham' => 'Tên sản phẩm',
        'category_id' => 'Danh mục',
        'gia' => 'Giá',
        'gia_khuyen_mai' => 'Giá khuyến mãi',
        'image' => 'Ảnh sản phẩm',
        'so_luong' => 'Số lượng',
        'trang_thai' => 'Trạng thái',
        'ngay_nhap' => 'Ngày nhập',
        'mo_ta' => 'Mô tả',
        'ten_khach_hang' => 'Tên khách hàng',
        'email' => 'Email',
        'so_dien_thoai' => 'Số điện thoại',
        'dia_chi' => 'Địa chỉ',
        'title'=>'Tiêu đề',
        'content'=>'Nội dung',
    ],
];

