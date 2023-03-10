<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionList extends Model
{

    protected $table = 'auction_list';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    public function auctions(){
        return $this->hasMany('id_auctioneer');
    }

}   