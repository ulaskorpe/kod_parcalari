<?php
	 	$table->integer('updated_by')->nullable()->default(0);
	 

    public function lastUpdated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

       $newCard=TankCard::with('lastUpdated')->find($id);

////observer
    public function saving(TankCard $tankCard) {
        $tankCard->updated_by = \Auth::id();

    }

?>



   		<div class="card-header">
            <div class="col-md-8">
                <h4 class="card-title"><i class="icon-card"> </i> {{__('Vehicles.update_tank_card')}}</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
            </div>
            <div class="col-md-4">
                @if(!empty($tank_card->updated_by))
                    ( {{__('drivers_companies.last_updated_by',['name'=>$tank_card->lastUpdated->fullname()])}} )
                @endif
            </div>
        </div>