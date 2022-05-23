@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start">{{ !empty($model->id) ? 'Редактирование' : 'Добавление' }} контакта</h5>
                        <a class="btn btn-sm btn-primary float-end" href="{{ route('contacts.index') }}"> К списку контактов</a>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ !empty($model->id) ? route('contacts.update',$model->id) : route('contacts.store') }}">
                            @csrf
                            @if(!empty($model->id))
                                {{ method_field('patch') }}
                            @endif
                            @include('contacts.form-fields')
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
