@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Liên Hệ Đã Xóa</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách liên hệ
    </a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->id }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>
                    @if ($contact->status)
                        <span class="badge bg-success">Đã phản hồi</span>
                    @else
                        <span class="badge bg-warning">Chưa phản hồi</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.contacts.restore', $contact->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary btn-sm">Khôi phục</button>
                    </form>
                    <form action="{{ route('admin.contacts.forceDelete', $contact->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xóa vĩnh viễn?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa vĩnh viễn</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $contacts->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
