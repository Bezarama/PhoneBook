@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h5>Здравствуйте, {{ Auth::user()->name }}!</h5>
                        <p>Используйте меню в шапке для доступа к своим контактам или воспользуйтесь <a href="{{ route('contacts.index') }}">этой ссылкой</a> для просмотра списка контактов или
                            <a href="{{ route('contacts.create') }}">добавьте новый</a>.</p>
                        <p>В <a href="{{ route('contacts.index') }}">списке контактов</a> можно:</p>
                        <ul>
                            <li>отсортировать контакты по любому полю</li>
                            <li>найти контакт по многим поисковым критериям</li>
                            <li>добавить в Избранное или удалить из него в один клик (см. кнопки с изображением звездочки <i class="fa fa-star text-warning"></i> в строке контакта)</li>
                            <li>удалить, отредактировать контакт или <a href="{{ route('contacts.create') }}">добавить новый</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
