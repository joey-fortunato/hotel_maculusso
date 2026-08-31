<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateSuperAdmin extends Command
{
    protected $signature = 'admin:super-admin
                            {--name= : Nome do super administrador}
                            {--email= : Email de acesso}';

    protected $description = 'Cria (ou promove) a conta de super administrador do painel.';

    public function handle(): int
    {
        $name = $this->option('name') ?: $this->ask('Nome');
        $email = $this->option('email') ?: $this->ask('Email');

        $validator = Validator::make(compact('name', 'email'), [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $existing = User::where('email', $email)->first();

        if ($existing) {
            if (! $this->confirm("Já existe uma conta com {$email}. Promover a super administrador?", true)) {
                return self::SUCCESS;
            }

            $existing->update(['is_admin' => true, 'is_super_admin' => true]);
            $this->info("Conta {$email} promovida a super administrador.");

            return self::SUCCESS;
        }

        $password = $this->secret('Palavra-passe (mín. 8 caracteres)');
        $confirm = $this->secret('Confirme a palavra-passe');

        if ($password !== $confirm) {
            $this->error('As palavras-passe não coincidem.');

            return self::FAILURE;
        }

        if (mb_strlen((string) $password) < 8) {
            $this->error('A palavra-passe deve ter pelo menos 8 caracteres.');

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
            'is_super_admin' => true,
        ]);

        $this->info("Super administrador {$email} criado com sucesso.");

        return self::SUCCESS;
    }
}
