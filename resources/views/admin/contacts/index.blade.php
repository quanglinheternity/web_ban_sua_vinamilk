@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh Sách Liên Hệ</h2>
    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form tìm kiếm -->
    <form method="GET" action="{{ route('admin.contacts.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Nhập tên" value="{{ request('name') }}">
            </div>
            <div class="col-md-4">
                <input type="text" name="email" class="form-control" placeholder="Nhập email" value="{{ request('email') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">-- Trạng thái --</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đã phản hồi</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Chưa phản hồi</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </div>
        </div>
    </form>
    @if (\App\Models\Contact::onlyTrashed()->count() > 0)
    <a href="{{ route('admin.contacts.trashed') }}" class="btn btn-warning btn-sm mb-3">Xem Liên Hệ Đã Xóa</a>
    @endif

    <!-- Danh sách liên hệ -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
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
                <td>{{ $contact->phone ?? 'N/A' }}</td>
                <td>
                    @if ($contact->status)
                        <span class="badge bg-success">Đã phản hồi</span>
                    @else
                        <span class="badge bg-warning">Chưa phản hồi</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-info btn-sm">Xem</a>
                    @if (!$contact->status)
                        <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="btn btn-warning btn-sm">Phản hồi</a>
                    @endif

                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xóa liên hệ này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Phân trang -->
    <div>
        {{ $contacts->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
