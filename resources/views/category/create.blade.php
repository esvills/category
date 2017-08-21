@extends('mage2-framework::layouts.admin')


@section('content')
    <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">Create Category</div>
                <div class="card-body">

                    {!! Form::open(['action' =>  route('admin.category.store'),'method' => 'POST']) !!}
                    @include('mage2-category::category._fields')

                    <div class="input-field">
                        {!! Form::submit("Create Category",['class' => 'btn btn-primary']) !!}
                        {!! Form::button("cancel",['class' => 'btn disabled','onclick' => 'location="' . route('admin.category.index'). '"']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection