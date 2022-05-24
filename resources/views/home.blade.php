@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h5>Здравствуйте, {{ Auth::user()->name }}!</h5></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h5>Контакты</h5>
                        <p>Используйте меню в шапке для доступа к своим контактам или воспользуйтесь <a href="{{ route('contacts.index') }}">этой ссылкой</a> для просмотра списка контактов или
                            <a href="{{ route('contacts.create') }}">добавьте новый</a>. <br/>
                            Если руками добавлять не хочется - можно <a href="{{ route('generate-random-contacts',10) }}">сгенерировать 10 случайных контактов</a>.
                        </p>
                        <p>В <a href="{{ route('contacts.index') }}">Списке контактов</a> можно:</p>
                        <ul>
                            <li>отсортировать контакты по любому полю</li>
                            <li>найти контакт по многим поисковым критериям</li>
                            <li>добавить в Избранное или удалить из него в один клик (см. кнопки с изображением звездочки <i class="fa fa-star text-warning"></i> в строке контакта)</li>
                            <li>удалить или отредактировать контакт</li>
                        </ul>

                        <p>&nbsp;</p>
                        <h5>API и работа с токенами</h5>
                        <p>Используйте пункт меню <a href="{{ route('token.index') }}">Управление токенами</a> для генерирования нового токена или отзыва существующих.</p>
                        <p>Документация Swagger: <a href="{{ url('/api/documentation') }}">{{ url('/api/documentation') }}</a></p>
                        Коллекция и окружение для Postman:
                        <ul class="list-unstyled">
                            <li>Collection: <a href="{{ url('postman/DZ-PhoneBookEnvironment.postman_environment.json') }}">{{ url('/postman/DZ-PhoneBookEnvironment.postman_environment.json') }}</a></li>
                            <li>Environment: <a href="{{ url('postman/DZ-PhoneBookCollection.postman_collection.json') }}">{{ url('/postman/DZ-PhoneBookCollection.postman_collection.json') }}</a></li>
                        </ul>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
