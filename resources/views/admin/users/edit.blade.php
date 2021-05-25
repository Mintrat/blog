@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Добавить пользователя
                <small>приятные слова..</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Добавляем пользователя</h3>
                    @include('admin.errors')
                </div>
                {{ Form::open(
                        [
                            'route' => ['users.update', $user->id],
                            'method' => 'put',
                            'files' => true
                        ]
                    )  }}
                <div class="box-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Имя</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">E-mail</label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Пароль</label>
                            <input type="password" name="password" class="form-control" placeholder="">
                        </div>

                        <div class="form-group">
                            <img src="{{ $user->getAvatar() }}" alt="" width="200" class="img-responsive">
                            <label for="exampleInputFile">Аватар</label>
                            <input type="file" name="avatar" >

                            <p class="help-block">Какое-нибудь уведомление о форматах..</p>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-default">Назад</button>
                    <button class="btn btn-warning pull-right" type="submit">Изменить</button>
                </div>
            {{ Form::close() }}
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
@endsection
