<?php

namespace Modules\Iauctions\Entities;

use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Ifillable\Traits\isFillable;


class Bid extends CrudModel
{
   
    use isFillable;

    protected $table = 'iauctions__bids';
    public $transformer = 'Modules\Iauctions\Transformers\BidTransformer';
    public $requestValidation = [
        'create' => 'Modules\Iauctions\Http\Requests\CreateBidRequest',
        'update' => 'Modules\Iauctions\Http\Requests\UpdateBidRequest',
      ];
   
    protected $fillable = [
        'auction_id',
        'description',
        'amount',
        'points',
        'status',
        'options'
    ];

    protected $casts = ['options' => 'array'];

    
    //============== RELATIONS ==============//

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    //============== MUTATORS / ACCESORS ==============//
    
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    
}
