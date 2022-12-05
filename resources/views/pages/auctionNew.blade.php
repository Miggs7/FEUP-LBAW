@extends('layouts.app')

@php 
   $categories = App\Http\Controllers\CategoryController::getCategories(); 
@endphp

@section('content')
    @if(!Auth::Check())
    <script>
        alert('You need to be logged in to create auctions!');
        window.history.back();
    </script>
    @endif
<div class="col-lg-6 align-items-center justify-content-left d-flex mb-5 mb-lg-0">
    <div class="blockabout">
        <div class="blockabout-inner text-center text-sm-start">
<form method="POST" action={{url('new')}}>
    {{ csrf_field() }}
    <p class="description-p text-muted pe-0 pe-lg-0">
        Create New Auction:
    </p>
    <label for="name">Name</label>
    <input id="name" type="text" name="name" required>

    <label for="description">Description </label>
    <input id="description" type="text" name="description" required>
      
    <label for="ending_date">Ending Date:</label>
    <input id="ending_date" type="date" name="ending_date" required>
    
    {{-- don't forget to hash passwords in the function of edit user --}}

    <label for="starting_bid">Starting Bid</label>
    <input id="starting_bid" type="number" name="starting_bid" required>

    <label for="item">Item </label>
    <input id="item" type="text" name="item">

    <label for="category"></label>Category</label>

    @foreach($categories as $category)
    <label for={{$category['name']}}></label>{{$category['type']}}</label>
    <input id="category" type="checkbox" name="category" value={{$category['id']}}>
    @endforeach

    <label for="image">Image URL</label>
    <input id="image" type="text" name="image">
    
    @if(Auth::user())
    <input id="id_auctioneer" type="hidden" name="id_auctioneer" value={{Auth::user()->id}}>
    @endif
    <button type="submit">
      Create
    </button>
</form>
    </div>
</div>
@endsection
