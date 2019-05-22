<?php

namespace Knovators\Masters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Knovators\Media\Models\Media;
use Knovators\Support\Traits\HasModelEvent;
use Knovators\Support\Traits\HasSlug;

/**
 * Class Master
 *
 * @package Knovators\Masters\Models
 */
class Master extends Model
{

    use SoftDeletes, HasSlug, HasModelEvent;

    protected $table = 'masters';

    protected $softDelete = true;


    protected $fillable = [
        'name',
        'code',
        'is_active',
        'parent_id',
        'image_id',
        'slug',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    protected $slugColumn = 'slug';

    protected $slugifyColumns = ['name', 'id'];


    /**
     *  Parent to child has many relationship
     * @return HasMany
     */
    public function childMasters() : HasMany {
        return $this->hasMany(Master::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent() {
        return $this->belongsTo(Master::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image() {
        return $this->belongsTo(Media::class, 'image_id', 'id')->select(['id', 'name','type','mime_type']);
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActive($query) {
        return $query->where('is_active', '=', 1);
    }

    /**
     * @param $query
     * @param $code
     * @return mixed
     */
    public function scopeWhereCode($query, $code) {
        if (is_array($code)) {
            return $query->whereIn('code', $code);
        }

        return $query->where('code', $code);
    }

}
