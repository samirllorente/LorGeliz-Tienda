<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\Dropbox\Client;
//use Illuminate\Support\Str;

class User extends Authenticatable
{
    public static function boot () {

        parent::boot();

        /*static::created(function(User $user) {
			
			$slug = \Str::slug($user->nombres. " " . $user->apellidos);
			
			$count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
			
            $user->slug = $count ? "{$slug}-{$count}" : $slug;
            
            if (request()->file('imagen')) {

                $imagen = request()->file('imagen');
                $nombre = time().'_'.$imagen->getClientOriginalName();
                //$imageName = \Str::random(20) . '.jpg';
                $image = Image::make($imagen)->encode('jpg', 75);
                $image->resize(128, 128, function ($constraint){
                    $constraint->upsize();
                });
                
                Storage::disk('dropbox')->put("users/$nombre", $image->stream()->__toString());
                $dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
                $response = $dropbox->createSharedLinkWithSettings("users/$nombre", ["requested_visibility" => "public"]);
                $path = str_replace('dl=0', 'raw=1', $response['url']);
                $imageName = $response['name'];

                $img = new Imagene();
                $img->nombre = $imageName;
                $img->url = $path;
                $img->imageable_type = 'App\User';
                $img->imageable_id = $user->id;

                $img->save();

                Cliente::create([
                    'user_id' => $user->id,
                ]);
            
            }
			
		});*/

       //implementar con dropbox
		static::saved(function(User $user) {
			
			if( ! \App::runningInConsole() ) {

				if (request()->file('imagen')) {
    
                    $imagen = request()->file('imagen');
                    $nombre = time().'_'.$imagen->getClientOriginalName();
                    $image = Image::make($imagen)->encode('jpg', 75);
                    $image->resize(128, 128, function ($constraint){
                        $constraint->upsize();
                    });
                    
                    Storage::disk('dropbox')->put("users/$nombre", $image->stream()->__toString());
                    $dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
                    $response = $dropbox->createSharedLinkWithSettings("users/$nombre", ["requested_visibility" => "public"]);
                    $path = str_replace('dl=0', 'raw=1', $response['url']);
                    $imageName = $response['name'];
                    //$path = Storage::disk('public')->putFileAs("imagenes/users/" . $user->id, $imagen, $nombre);
    
                    $img = new Imagene();
                    $img->nombre = $imageName;
                    $img->url = $path;
                    $img->imageable_type = 'App\User';
                    $img->imageable_id = $user->id;

                    $img->save();

                    if ($user->cliente) {
                        $imagen = Imagene::where('imageable_type','App\User')
                        ->where('imageable_id', auth()->user()->id)->first();

                        if ($imagen != '') {
                            $delete = $this->dropbox->delete($imagen->nombre);
                            //$delete = $this->dropbox->delete($imagen->url);
                            $imagen->delete();
                        }

                    } else {
                        Cliente::create([
                            'user_id' => $user->id,
                        ]);
                    }
                   
                }
			}
		});

    }
    
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'identificacion','nombres', 'apellidos', 'direccion', 'telefono', 'email', 'username','password','imagen', 'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //public static function navigation (){
    	//return auth()->check() ? auth()->user()->role->nombre : 'guest';
    //}

    public function role (){
        return $this->belongsTo(Role::class);
    }

    public function cliente (){
        return $this->hasOne(Cliente::class);
    }

    public function imagene (){
        return $this->morphOne('App\Imagene','imageable');
    }
}
