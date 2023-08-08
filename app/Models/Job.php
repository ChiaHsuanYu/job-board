<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'location', 'salary', 'description', 'experience', 'category' 
    ];

    // public static array $experience = ['初階', '中階', '高階'];
    // public static array $category = ['資訊科技', '金融', '銷售', '營銷']; 

    public static array $experience = [
        'entry'=> '1', 
        'intermediate' => '2', 
        'senior' => '3'
    ];
    public static array $category = [
        'IT' => '1', 
        'Finance' => '2', 
        'Sales' => '3', 
        'Marketing' => '4'
    ]; 


    // 取得所有工作的雇主資料
    public function employer(): BelongsTo{
        return $this->belongsTo(Employer::class);
    }

    // 取得所有工作的應徵名單
    public function jobApplications(): HasMany{
        return $this->hasMany(JobApplication::class);
    }

    // 取得特定工作的申請狀態 by user_id
    public function hasUserApplied(Authenticatable|User|int $user):bool {
        return $this->where('id', $this->id)
            ->whereHas('jobApplications',function ($query) use ($user){
                $query->where('user_id', $user->id ?? $user);
            })->exists();
    }

    // 取得所有工作資料(條件查詢)
    public function scopeFilter(Builder | QueryBuilder $query, array $filters): Builder | QueryBuilder {
        return $query->when($filters['search'] ?? null, function ($query, $search){
            $query->where(function ($query) use ($search){
                 $query->where('title','like','%'.$search.'%')
                 ->orWhere('description','like','%'.$search.'%')
                 ->orWhereHas('employer', function ($query) use ($search){
                    $query->where('company_name','like','%'.$search.'%');
                 });
            });
         })->when($filters['min_salary'] ?? null,function ($query, $min_salary){
             $query->where('salary', '>=', $min_salary);
         })->when($filters['max_salary'] ?? null,function ($query, $max_salary){
             $query->where('salary', '<=', $max_salary);
         })->when($filters['experience'] ?? null, function ($query, $experience){
             $query->where('experience', $experience);
         })->when($filters['category'] ?? null, function ($query, $category){
             $query->where('category', $category);
         });
    }
}
