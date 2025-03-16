
@extends('layouts.admin')

@section('title', 'Редактирование категории')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование категории: {{ $category['long_name'] }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4 class="mb-1"><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4 class="mb-1"><i class="icon fa fa-check"></i>
                        {{ session('error') }}
                    </h4>
                </div>
            @endif
            
            @if (session('errors'))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </h4>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('category.update', $category['id']) }}" method="POST" onsubmit="onSubmitCreateProduct()">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название</label>
                                    <input type="text" value="{{ $category['long_name'] }}" name="long_name" class="form-control"
                                        id="exampleInputEmail1" placeholder="Введите название категории" required>
                                </div>

                                <div class="form-group">
                                    <label class="h5">Описание категории</label>
                                    <textarea name="description" class="editor">{{ $category['description'] }}</textarea>
                                </div>
                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-lg">Обновить категорию</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="admin-create-product-loading">
                <div class="loading-ring"></div>
                <div class="loading-text">Data is loading. Please wait.</div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
