<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * 
     * 
     */

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'profile_img',
        'password'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
    public function transactions_send(): HasMany
    {
        return $this->hasMany(Transaction::class,'sender_id');
    }
    public function transactions_receive(): HasMany{
        return $this->hasMany(Transaction::class,'receiver_id');
    }
    public function getNetBalance()
    {
        return $this->transactions()->sum('amount');
    }

    public function latestTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->latestOfMany();
    }
    public function oldestTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->oldestOfMany();
    }

    //getting highest transaction ever to this user
    public function highestAmountGiven(): HasOne
    {
        return $this->hasOne(Transaction::class)->ofMany('amount', 'max');
    }
    //lowest
    public function lowestAmount(): HasOne
    {
        return $this->hasOne(Transaction::class)->ofMany('amount', 'min');
    }


    //roles
    public function roles(): BelongsToMany
    {
        // in (Role::class,'your_table') otherwise convetion is role_user
        return $this->belongsToMany(Role::class);
    }

    public function profile_pic(){
        if($this->profile_img&&$this->profile_img!=" " && !$this->hasRole('admin')){
            return url('storage/'.$this->profile_img);
        }
        return 'assets/img/profile-img.jpg';
    }

    public function trasactionsWith(User $user){

        return Transaction::where(function($qry)use ($user){
            $qry->where('sender_id',$this->id)->where('receiver_id',$user->id);
        } )->orWhere(function($qry) use($user){
            $qry->where('sender_id',$user->id)->where('receiver_id',$this->id);
        })->get();
    }

    public function netBalanceWithUser(User $user){
        $trans= Transaction::where(function($qry)use ($user){
            $qry->where('sender_id',$this->id)->where('receiver_id',$user->id);
        } )->orWhere(function($qry) use($user){
            $qry->where('sender_id',$user->id)->where('receiver_id',$this->id);
        })->get();
        $netBalance =0;
        foreach ($trans as $id => $t) {
            $amount = $t->amount;
            if($t->sender_id==$user->id){
                $amount=-$amount;
            }
            $netBalance+= $amount;
        }
        return $netBalance;
    }

    //banks

    public function BankTransactions(){

        return Transaction::where('bank_id',$this->id)->with('sender','receiver')->get();
    }

    public function banks():BelongsToMany{
        return $this->belongsToMany(User::class,'bank_users','user_id','bank_id')->withPivot('verified','id');//users has banks
    }
    public function users():BelongsToMany{
        return $this->belongsToMany(User::class,'bank_users','bank_id','user_id')->withPivot('verified','id');  // banks has users
    }



    //admin parts

    public function allExceptAdmins(){
        return static::whereHas('roles', function ($qry) {
            $qry->where('name', '!=', 'admin');
        })->get();
    }
    
}
