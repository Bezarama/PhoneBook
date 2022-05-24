@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-sm btn-primary" href="{{ route('contacts.create') }}"><i class="fa fa-plus-circle"></i> Добавить</a>
                        <div class="float-end favourites-filter-btns" style="display: none">
                            <a href="javascript:void(0)" class="btn btn-outline-secondary btn-sm active favourite-criteria-set" data-criteria="all">
                                <i class="fa fa-star-half-stroke text-warning"></i> все
                            </a>
                            <a href="javascript:void(0)" class="btn btn-outline-secondary btn-sm favourite-criteria-set" data-criteria="favouritesOnly">
                                <i class="fa fa-star text-warning"></i> избранное
                            </a>
                            <a href="javascript:void(0)" class="btn btn-outline-secondary btn-sm favourite-criteria-set" data-criteria="nonFavouritesOnly">
                                <i class="fa fa-star "></i> не избранное
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered table-hover text-sm"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="text" id="favourite-criteria" class="d-none" value="all">
@endsection

@section('js')

    <script>

        $(document).ready(function () {

            window.table = $("#datatable").DataTable({
                language: {
                    url: "{{ asset('js/datatables/Russian.json') }}"
                },
                order: [1, "asc"],
                aLengthMenu: [[20, 50, 100, -1], [20, 50, 100, "Все"]],
                keepConditions: true,
                bStateSave: true,
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    url: getDatatablesAjaxUrl(),
                    type: "POST"
                },

                columns: [
                    {data: 'id', name: 'id', title: "ID"},
                    {data: 'first_name', name: 'first_name', title: "Имя"},
                    {data: 'middle_name', name: 'middle_name', title: "Отчество"},
                    {data: 'last_name', name: 'last_name', title: "Фамилия"},
                    {
                        data: 'phone', name: 'phone', title: "Телефон",
                        render: function (data, type, row) {
                            return '<span class="inputmask">' + data + '</span>';
                        }
                    },
                    {
                        data: 'updated_at', name: 'updated_at', title: "Обновлено", searchable: false,
                        render: function (data, type, row) {
                            return data ? moment(data).format('DD.MM.YYYY HH:mm:ss') : '';
                        }
                    },
                    {
                        data: 'is_favourite',
                        title: "<span class='text-success' title='Клик по звездочке переключает статус '>Избранное *</span>",
                        searchable: false,
                        render: function (data, type, row) {
                            return '<a class="fav-change-status" data-id="' + row.id + '" href="javascript:void(0);"  title="' + (data ? 'Удалить из избранного' : 'Добавить в избранное') + '"><i class="fa fa-star text-' + (data ? 'warning' : 'secondary-light') + '"></i></a>';
                        }
                    },
                    {
                        data: 'id',
                        title: '',
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row) {
                            let urlEdit = '{{ route("contacts.edit", ":id") }}';
                            urlEdit = urlEdit.replace(':id', row.id);
                            let urlShow = '{{ route("contacts.show", ":id") }}';
                            urlShow = urlShow.replace(':id', row.id);
                            return '<a class="btn btn-sm btn-primary" href="' + urlEdit + '"  title="Редактировать"><i class="fa fa-edit"></i></a>'
                                + '<a class="btn btn-sm btn-success mx-3" href="' + urlShow + '"  title="Просмотреть"><i class="fa fa-eye"></i></a>'
                                + '<a class="btn btn-sm btn-danger" onclick="deleteItem(' + row.id + ')" href="javascript:void(0);"  title="Удалить"><i class="fa fa-delete-left"></i></a>';
                        }
                    },
                ],
                drawCallback: function (settings) {

                    let rows = this.fnGetData();

                    if (rows.length === 0) {
                        $('#datatable_paginate').hide();
                        $('.favourites-filter-btns').hide();
                    } else {
                        $('#datatable_paginate').show();
                        $('.favourites-filter-btns').show();
                    }

                    Inputmask({mask: mask}).mask('.inputmask');
                }
            });


            $(document).on('click', '.favourite-criteria-set', function (e) {

                $('.favourite-criteria-set').removeClass('active');
                $(this).addClass('active');

                let criteria = $(this).attr('data-criteria');
                $('#favourite-criteria').val(criteria);

                table.ajax.url(getDatatablesAjaxUrl());
                table.ajax.reload();

            });


            $(document).on('click', '.fav-change-status', function (e) {

                let id = $(this).attr('data-id');

                let url = '{{ route("contacts.toggle-favourite", ":id") }}';
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'PATCH',
                    success: function (resp, textStatus, errorThrown) {
                        if (resp.status && resp.status == 'success') {
                            Swal.fire({
                                title: resp.message,
                                icon: "success",
                                timer: 1500,
                            });
                        } else {
                            let message = resp.responseJSON.message ? resp.responseJSON.message : errorThrown;
                            Swal.fire({
                                title: 'Ошибка',
                                text: message,
                                icon: "error",
                            });
                        }
                    },
                    complete: function () {
                        table.ajax.reload(null, false);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        let message = jqXHR.responseJSON.message ? jqXHR.responseJSON.message : errorThrown;
                        Swal.fire({
                            title: 'Ошибка',
                            text: message,
                            icon: "error",
                        });
                    }
                });

            });

        });

        function redrawAfterDelete(tableToRedraw) {
            var info = tableToRedraw.page.info();
            if (info.page > 0) {
                // when we are in the second page or above
                if (info.recordsTotal - 1 > info.page * info.length) {
                    // after removing 1 from the total, there are still more elements
                    // than the previous page capacity
                    tableToRedraw.draw(false)
                } else {
                    // there are less elements, so we navigate to the previous page
                    tableToRedraw.page('previous').draw('page')
                }
            } else {
                tableToRedraw.draw(false)
            }
        }

        function getDatatablesAjaxUrl() {
            let url = '{{ route('contacts.datatables-data',':favouriteCriteria') }}';
            return url.replace(':favouriteCriteria', $('#favourite-criteria').val());
        }

        function deleteItem(id) {

            Swal.fire({
                title: "Вы уверены, что хотите удалить эту запись?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Подтвердить",
                cancelButtonText: "Отмена",
            }).then((result) => {

                if (result.value) {

                    let url = '{{ route("contacts.destroy", ":id") }}';
                    url = url.replace(':id', id);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        url: url,
                        type: 'DELETE',
                        success: function (resp) {
                            if (resp.status && resp.status == 'success') {
                                Swal.fire({
                                    title: resp.message,
                                    icon: "success",
                                    timer: 1500,
                                });
                            } else {
                                let message = resp.message ? resp.message : resp;
                                Swal.fire({
                                    title: 'Ошибка',
                                    text: message,
                                    icon: "error",
                                });
                            }
                        },
                        complete: function () {
                            redrawAfterDelete(table);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            let message = jqXHR.responseJSON.message ? jqXHR.responseJSON.message : errorThrown;
                            Swal.fire({
                                title: 'Ошибка',
                                text: message,
                                icon: "error",
                            });
                        }
                    });

                }
            })
        }


    </script>
@endsection
