@extends('admin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Добавить тег
                <small>приятные слова..</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                {{ Form::open([
                    'route' => ['tags.update', $tag->id],
                    'method' => 'put'
                ]) }}
                <div class="box-header with-border">
                    <h3 class="box-title">Меняем тег</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Название</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title" value="{{ $tag->title }}">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-default">Назад</button>
                    <button class="btn btn-warning pull-right" type="submit">Изменить</button>
                </div>
                <!-- /.box-footer-->
                {{ Form::close() }}
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
@endsection
