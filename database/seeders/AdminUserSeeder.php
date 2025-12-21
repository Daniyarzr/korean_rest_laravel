<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём администратора
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@kimchihouse.ru',
            'password' => Hash::make('admin123'), // Смените на сложный пароль!
            'role' => 'admin',
        ]);

        // Можно создать тестового менеджера
        User::create([
            'name' => 'Менеджер',
            'email' => 'manager@kimchihouse.ru',
            'password' => Hash::make('manager123'),
            'role' => 'manager',
        ]);

        $this->command->info('Администратор и менеджер созданы!');
        $this->command->info('Email: admin@kimchihouse.ru / Password: admin123');
        $this->command->info('Email: manager@kimchihouse.ru / Password: manager123');
    }
}