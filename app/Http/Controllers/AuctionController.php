<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use App\Models\AuctionImage;
use App\Models\User;

class AuctionController extends Controller
{
  /**
   * Gets auction by it's id.
   *
   * @param  int  $id
   * @return Response
   */
  public static function getAuction($id)
  {
    $auction = Auction::find($id);
    return $auction;
  }

    /**
   * function updates bid.
   *  
   * @param Request $request
   * @return redirect
   */
  public static function bid(Request $request)
  { 

    $time = now();

    /*use a query to obtain current_bid from db and compare with bid_value */

    $request->validate(array(
      'id_bidder' => 'required|numeric',
      'current_bid' => 'required_with:bid_value|integer',
      'bid_value' => 'required_with:current_bid|integer|gt:current_bid',
    ));
    
    $auction = Auction::find($request['id']);

    /*Case auction is over*/
    if($time >= $auction['ending_date']){
      return redirect('/auction/'.$auction['id']);
    }
    
    /*Trigger will verify if value is valid*/
    $auction->current_bid  = $request['bid_value'];
    $auction->save();

    $bid = new Bid;
    $bid->id_bidder = $request['id_bidder'];
    $bid->id_auction = $request['id'];
    $bid->bid_value = $request['bid_value'];
    $bid->save();

    $bidder = User::find($request['id_bidder']);

    return redirect('/auction/'.$auction['id']);
  }

      /**
   * Update auction.
   *
   * @param  Request  $request
   * @return redirect
   */
  public static function updateAuction(Request $request){

    $time = now();

    $request->validate(array(
      'name' => 'nullable|string|max:255',
      'description' => 'nullable|string|max:255',
      'ending_date' => 'nullable|date|after_or_equal:'.$time,
    ));

    $auction = Auction::find($request->id);

    if($request->name) $auction->name = $request->name;
    if($request->description) $auction->description = $request->description;
    if($request->ending_date) $auction->ending_date = $request->ending_date;
  
    $auction->save();

    return response()->json(['name'=>$request['name'],'description'=>$request['description'],'ending_date'=>$request['ending_date']],200);
    //return redirect('/auction/'.$auction->id);
  }

        /**
   * Delete incomplete auction.
   *
   * @param  Request  $request
   * @return redirect
   */
  public static function delete(Request $request){

    $input = $request->input();
    $auction = Auction::find($input['id']);
    $auction_image = AuctionImageController::getAuctionImage($auction->id);
    /*remove image from folder*/
    unlink(public_path().$auction_image['link']);
    /*delete from database*/
    $auction->delete();    
    $auction_image->delete();
    return redirect('/');
  }

          /**
   * Create new auction.
   *
   * @param  Request  $request
  *  @return redirect
   */
  public static function create(Request $request){

    $time = now();

    $request->validate(array(
      'name' => 'required|string|max:255',
      'description' => 'required|string|max:255',
      'ending_date' => 'required|date',  
      'starting_bid' => 'required|numeric', 
      'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
      'ending_date' => 'required|date|after_or_equal:'.$time
    ));

    //return $request;

    $auction = new Auction;
    $auction-> name = $request['name'];
    $auction-> description = $request['description'];
    $auction-> ending_date = $request['ending_date'];
    /*at the start of bid the current and starting bid will be the same*/
    $auction-> current_bid = $request['starting_bid'];
    $auction-> starting_bid = $request['starting_bid'];
    $auction->save();

    /*image to public folder*/
    $imageName = 'auction'.$auction['id'].'.'.$request->image->extension();
    $request->image->move(public_path('images/auction/'), $imageName);
    $img_path = '/images/auction/'.$imageName;

    /*image to AuctionImage table */
    app('App\Http\Controllers\AuctionImageController')->create($img_path,$auction['id']);
    /*add auctioneer and auction to auction_list */
    app('App\Http\Controllers\AuctionListController')->create($request['id_auctioneer'],$auction['id']);
    /*add auction and category to auction_category */
    app('App\Http\Controllers\AuctionCategoryController')->create($request['category'],$auction['id']);
    
    return redirect('/auction/'.$auction['id']);
  }
}