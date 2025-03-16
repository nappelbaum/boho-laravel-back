@extends('layouts.admin')

@section('title', 'Список категорий')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Список категорий</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->

      @if (session('success') && session('success') != 'Категория была успешно обновлена')
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4 class="mb-1"><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
        </div>
      @endif

      @if (session('errors'))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4 class="mb-1"><i class="icon fa fa-check"></i>
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
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            {{-- <th style="width: 5%">
                                ID
                            </th> --}}
                            <th>
                                Название
                            </th>
                            <th>
                                Дата создания
                                @if ($method == 'asc')
                                    <a href="{{ route('category.index', 'method=desc') }}" class="ml-2" title="Кликните для сортировки по убыванию">
                                        <i class="fas fa-solid fa-lg fa-caret-up"></i>
                                    </a>
                                @else
                                    <a href="{{ route('category.index', 'method=asc') }}" class="ml-2" title="Кликните для сортировки по возрастанию">
                                        <i class="fas fa-solid fa-lg fa-caret-down"></i>
                                    </a>
                                @endif
                            </th>
                            <th style="width: 30%">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr id="editBlock">
                                
                                    {{-- <td>
                                        {{ $category['id'] }}
                                    </td> --}}
                                    <td>
                                        <a href="{{ route('category.edit', $category['id']) }}" style="color: inherit">
                                            {{ $category['long_name'] }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $category['created_at'] }}
                                    </td>

                                    <td class="project-actions text-right">
                                        <button class="btn btn-info btn-sm" id="openEditBtn">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('category.destroy', $category['id']) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                            </tr>  
                            <tr id="hideEditBlock" class="d-none">
                                <td colspan="3" class="p-0">
                                        
                                    <form action="{{ route('category.update', $category['id']) }}" method="POST"
                                        class="w-100 d-flex bg-transparent">
                                        @csrf
                                        @method('PATCH')
                                        
                                        {{-- <div class="card-body d-none">
                                            <div class="form-group mb-1">
                                                <label for="exampleInputEmail0">Название</label>
                                                <input type="text" value="{{ $category['long_name'] }}" name="long_name" class="form-control"
                                                    id="exampleInputEmail0" required>
                                            </div>
                                        </div> --}}

                                        <div class="card-body w-100">
                                            <div class="form-group mb-1">
                                                <label for="exampleInputEmail1">Изменить дату, время</label>
                                                <input type="datetime-local" value="{{ $category['created_at'] }}" name="created_at" class="form-control"
                                                    id="exampleInputEmail1" required>
                                            </div>
                                        </div>

                                        <div class="card-body bg-transparent d-flex flex-column justify-between">
                                            <button type="submit" class="btn btn-primary btn-sm mb-2">Сохранить</button>

                                            <a class="btn btn-info btn-sm" href="{{ route('category.edit', $category['id']) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                Редактировать запись
                                            </a>
                                        </div>
                                    </form>
                                
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div><!-- /.container-fluid -->
  </section>

@endsection