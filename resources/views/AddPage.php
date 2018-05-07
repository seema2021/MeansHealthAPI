<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddPage extends Model {

    protected $table = 'add_pages';
    protected $fillable = ['name', 'header', 'title', 'image', 'menu'];

    public function updateOld($data) {
        return $this->update($data);
    }

    public function submenu() {
        return $this->belongsTo('\App\Menu', 'menu');
    }

}
