@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Токен для доступа к API
                    </div>
                    <div class="card-body">

                        <p>Последний раз токен генерировался: {!! $tokens->last()->created_at ?? '<span class="text-danger">никогда</span>' !!}</p>
                        @if($tokens->count())
                            <div class="float-end">
                                <form action="{{ route('token.delete') }}" method="GET">
                                    @csrf
                                    <input type="submit" class="btn btn-danger" value="Отозвать все токены">
                                </form>
                            </div>
                        @endif

                        <form action="{{ route('token.generate') }}" method="GET">
                            @csrf
                            <input type="submit" class="btn btn-primary" value="Сгенерировать новый токен">
                        </form>

                        @if(session()->has('new_token'))
                            <div class="alert alert-success mt-3">
                                Новый токен:
                                <p>{{ session('new_token') }}</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
