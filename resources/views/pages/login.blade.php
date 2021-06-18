@extends('layout')
@section('content')
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div class="leave-comment mr0"><!--leave comment-->
                @if (session('status'))
                    <div class="alert alert-danger">
                        {{ session('status') }}
                    </div>
                @endif
                    <h3 class="text-uppercase">Login</h3>
                    @include('admin.errors')
                    <br>
                    <form class="form-horizontal contact-form" role="form" method="post" action="/login">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="email"
                                       value="{{ old('email') }}"
                                       placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password"
                                       placeholder="password">
                            </div>
                        </div>
                        <button type="submit" class="btn send-btn">Login</button>

                    </form>
                </div><!--end leave comment-->
            </div>
            @include('pages.sidebar')
        </div>
    </div>
</div>
@endsection
