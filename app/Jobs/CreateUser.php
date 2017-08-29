<?php

namespace App\Jobs;

use App\Events\UserCreated;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Artesaos\Defender\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $name;
    private $email;
    private $role;

    public function __construct(string $name, string $email, Role $role)
    {
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    public static function fromRequest(UserCreateRequest $request): self
    {
        return new static($request->name(), $request->email(), $request->role());
    }

    public function handle()
    {
        \DB::transaction(function() {
            $user = new User(['name' => $this->name, 'email' => $this->email]);
            $user->invitation_token = hash_hmac('sha256', str_random(40), config('APP_KEY'));
            $user->save();
            $user->attachRole($this->role);

            event(new UserCreated($user));
        });
    }
}
