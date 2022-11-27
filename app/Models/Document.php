<?php

namespace App\Models;

use App\Traits\MultiTenantAssetTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;

class Document extends Model
{
    use SoftDeletes, HasMedia, MultiTenantAssetTrait;

    protected $appends = [
        'document',
    ];

    protected $fillable = [
        'description', 'asset_id', 'tenant_id',
    ];

    public function getDocumentAttribute()
    {
        return $this->getMedia('document')->last();
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
