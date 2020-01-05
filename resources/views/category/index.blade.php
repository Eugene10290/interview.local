@extends('layouts.app')

@section('content')

    <table class="table">

        <thead>
            <a class="btn btn-primary" href="{{ route('category.create') }}" >Создать категорию</a>
            <tr>
                <th>Наименование</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td> {{ $category->title ?? 'Наименоание не определено' }}</td>
                    <td class="text-right">
                        <a class="btn btn-primary" href="{{ route('category.edit', $category) }}"> Редактировать </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">
                        <h1 class="text-center">Категории отсутствуют</h1>
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
@endsection
