@extends('layouts.app')

@section('content')
<div class="container">
    <h1>カテゴリ作成</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="categoryName" class="form-label">カテゴリ名</label>
            <input type="text" class="form-control" id="categoryName" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">作成</button>
    </form>
</div>
@endsection