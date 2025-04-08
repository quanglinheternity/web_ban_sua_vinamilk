@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Phản hồi liên hệ</h2>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Thông tin liên hệ</h5>
        </div>
        <div class="card-body">
            <p><strong>Tên:</strong> {{ $contact->name }}</p>
            <p><strong>Email:</strong> {{ $contact->email }}</p>
            <p><strong>Điện thoại:</strong> {{ $contact->phone ?? 'Không có' }}</p>
            <p><strong>Nội dung:</strong> {{ $contact->message }}</p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-success text-white">
            <h5>Gửi phản hồi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contacts.sendReply', $contact->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nội dung phản hồi</label>
                    <textarea name="reply_message" class="form-control @error('reply_message') is-invalid @enderror" rows="5"></textarea>
                    @error('reply_message') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-success">Gửi phản hồi</button>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
