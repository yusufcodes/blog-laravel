{{-- Errors Partial
Curates all errors via all() method, loops through each one using a foreach loop, then outputs each error. --}}

@if(count($errors->all()))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif