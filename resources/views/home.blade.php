@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <form action="{{ route('comments.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class='form-group'>
                            <textarea name="content" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-primary">Commenter</button>
                    </form> 
                    
                    <h2>Comments</h2>  
                    @foreach($comments as $comment)
                       <p>{{ $comment->content }}</p>
                    @endForeach
                       
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
