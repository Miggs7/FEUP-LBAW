<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use app\Http\Controllers\ItemController;

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
    $input = $request->input();
    $auction = Auction::find($input['id']);
    
    /*Trigger will verify if value is valid*/
    $auction->current_bid  = $input['bid_value'];
    $auction->save();

    return redirect('/auction/'.$auction->id);
  }

      /**
   * Update auction.
   *
   * @param  Request  $request
   * @return redirect
   */
  public static function updateAuction(Request $request){

    $input = $request->input();
    $auction = Auction::find($input['id']);

    if($input['name']){
      $auction->name = $input['name'];
      $auction->save();
    }

    if($input['description']){
      $auction->description = $input['description'];
      $auction->save();
    }

    if($input['starting_bid']){
      $auction->starting_bid = $input['starting_bid'];
      $auction->save();
    }

    if($input['ending_date']){
      $auction->ending_date = $input['ending_date'];
      $auction->save();
    }
    
    if($input['id_item']){
      $auction->id_item = $input['id_item'];
      $auction->save();
    }

    if($input['ongoing']){
      $auction->ongoing = $input['ongoing'];
      $auction->save();
    }

    return redirect('/auction/'.$auction->id);
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
    $auction->delete();    
    return redirect('/');
  }

          /**
   * Create new auction.
   *
   * @param  Request  $request
  *  @return redirect
   */
  public static function create(Request $request){
    $input = $request->input();
    $auction = new Auction;
    $auction-> name = $input['name'];
    $auction-> description = $input['description'];
    $auction-> ending_date = $input['ending_date'];
    /*at the start of bid the current and starting bid will be the same*/
    $auction-> current_bid = $input['starting_bid'];
    $auction-> starting_bid = $input['starting_bid'];
    $auction->id_item = app('App\Http\Controllers\ItemController')->getIdFromName($input['item']);
    //$auction->id_item = ItemController::getNameFromId($input['id_item']);
    $auction->save();
    return redirect('/');
  }
}