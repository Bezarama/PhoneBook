@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start">Детали контакта</h5>
                        <a class="btn btn-sm btn-primary float-end" href="{{ route('contacts.index') }}"> К списку контактов</a>
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-auto text-end text-primary">
                                <h5>Имя:</h5>
                            </div>
                            <div class="col-auto">
                                <h5>{{ $model->first_name }}</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-auto text-end text-primary">
                                <h5>Отчество:</h5>
                            </div>
                            <div class="col-auto">
                                <h5>{{ $model->middle_name }}</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-auto text-end text-primary">
                                <h5>Фамилия:</h5>
                            </div>
                            <div class="col-auto">
                                <h5>{{ $model->last_name }}</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-auto text-end text-primary">
                                <h5>Телефон:</h5>
                            </div>
                            <div class="col-auto">
                                <h5 class="inputmask">{{ $model->phone }}</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-auto text-end text-primary">
                                <h5>В избранном?</h5>
                            </div>
                            <div class="col-auto">
                                <h5>{{ $model->is_favourite ? 'да' : 'нет' }}</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
