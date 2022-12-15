@extends('layouts.app')

@php
    /*in case we're in other use profile we'll need to get his profile*/
    $id = request()->route('id');
    $counter = 0;
    $user = App\Http\Controllers\UserController::getUserById($id); 
    /*array with auctions that user is watching*/
    $watching = App\Http\Controllers\WatchListController::getBidderWatchList($id); 
@endphp

@section('content')

<div class="h-100 d-flex align-items-center justify-content-center">
    <h2 class="categories-titles my-3" id="{{$user['username']}}"> {{$user['username']}}'s Watchlist </h2>
</div>
    <hr class="mb-5">
<div class="container">
        <div class="row">
        @foreach($watching as $watch)
            @php
            $auction = App\Http\Controllers\AuctionController::getAuction($watch->id_auction);
            $img = App\Http\Controllers\AuctionImageController::getAuctionImage($watch->id_auction);
            $counter++;
            @endphp

<div class="col-sm">
            <figure class="img-column">
                <a href={{url("/auction/".$watch->id_auction)}}><img src= "{{$img['link']}}" alt="Auction image" width="200" height="200"></a>
                <figcaption>{{$auction['name']}}</figcaption>   
            </figure>
</div>
@if($counter % 3 == 0)
<div class="row">
@endif
@endforeach 
    </div>
</div>
@endsection
