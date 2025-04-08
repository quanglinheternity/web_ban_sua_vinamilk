@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Chi Tiết Liên Hệ</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Tên:</strong> {{ $contact->name }}</p>
            <p><strong>Email:</strong> {{ $contact->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $contact->phone ?? 'Không có' }}</p>
            <p><strong>Nội dung:</strong> {{ $contact->message }}</p>
            <p><strong>Trạng thái:</strong>
                @if ($contact->status)
                    <span class="badge bg-success">Đã phản hồi</span>
                @else
                    <span class="badge bg-warning">Chưa phản hồi</span>
                @endif
            </p>

            @if (!$contact->status)
                <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="btn btn-info">Phản hồi</a>
            @endif
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection
