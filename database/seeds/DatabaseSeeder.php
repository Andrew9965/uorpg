<?php

use App\Models\MainMenu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MainMenuSeeder::class);
//        $this->call(BackupSeeder::class);


    }
}

class BackupSeeder extends Seeder
{
    public function run()
    {
        Eloquent::unguard();
        $path = 'database/backup/*.sql';
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::unprepared(file_get_contents($path));
        $this->command->info('Default table seeded');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}


class RoleSeeder extends Seeder
{
    public function run()
    {
        $owner = new \App\Role();
        $owner->name = 'owner';
        $owner->display_name = 'Владелец'; // optional
        $owner->description = 'Все права'; // optional
        $owner->save();

        $admin = new \App\Role();
        $admin->name = 'admin';
        $admin->display_name = 'Администратор'; // optional
        $admin->description = 'Все возможности'; // optional
        $admin->save();

        $moderator = new \App\Role();
        $moderator->name = 'moderator';
        $moderator->display_name = 'Модератор'; // optional
        $moderator->description = 'Редактировать контент'; // optional
        $moderator->save();

        $this->command->info('Role table seeded!');

    }
}

class UserSeeder extends Seeder
{
    public function run()
    {
        $owner = new \App\User();
        $owner->name = 'owner';
        $owner->email = 'owner@owner.owner';
        $owner->password = bcrypt('owner');
//        $owner->is_active = '1';
        $owner->save();
        $owner->attachRole('1');

        $admin = new \App\User();
        $admin->name = 'admin';
        $admin->email = 'admin@admin.admin';
        $admin->password = bcrypt('admin');
//        $admin->is_active = '1';
        $admin->save();
        $admin->attachRole('2');


        $moderator = new \App\User();
        $moderator->name = 'moderator';
        $moderator->email = 'moderator@moderator.moderator';
        $moderator->password = bcrypt('moderator');
//        $moderator->is_active = '1';
        $moderator->save();
        $moderator->attachRole('3');

        $this->command->info('Standart User table seeded!');

    }
}


class MainMenuSeeder extends Seeder
{
    public function run()
    {
        $menu = MainMenu::create([
            'title_ru' => 'Главное меню',
            'title_en' => 'Main menu',
//            'url' => '',
            'priority' => 100,
            'is_active' => 1,
            'is_dropdown' => 1,
//            'parent_id' => ''
        ]);

        MainMenu::create([
            'title_ru' => 'Рынок',
            'title_en' => 'Market',
            'url' => '#',
            'priority' => 97,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        MainMenu::create([
            'title_ru' => 'Активные игроки',
            'title_en' => 'Active player',
            'url' => '#',
            'priority' => 95,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        MainMenu::create([
            'title_ru' => 'Активные игроки',
            'title_en' => 'Active player',
            'url' => '#',
            'priority' => 93,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);


        MainMenu::create([
            'title_ru' => 'Персонажи',
            'title_en' => 'Characters',
            'url' => '#',
            'priority' => 91,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        MainMenu::create([
            'title_ru' => 'Соревнования',
            'title_en' => 'Competitions',
            'url' => '#',
            'priority' => 89,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);


        $menu = MainMenu::create([
            'title_ru' => 'Начать играть',
            'title_en' => 'Start play',
            'url' => '#',
            'priority' => 85,
            'is_active' => 1,
            'is_dropdown' => 0,
//            'parent_id' => ''
        ]);

        $menu = MainMenu::create([
            'title_ru' => 'Информация',
            'title_en' => 'Information',
//            'url' => '#',
            'priority' => 83,
            'is_active' => 1,
            'is_dropdown' => 1
//            'parent_id' => ''
        ]);


        MainMenu::create([
            'title_ru' => 'Рынок',
            'title_en' => 'Market',
            'url' => '#',
            'priority' => 81,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        MainMenu::create([
            'title_ru' => 'Активные игроки',
            'title_en' => 'Active player',
            'url' => '#',
            'priority' => 79,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        MainMenu::create([
            'title_ru' => 'Активные игроки',
            'title_en' => 'Active player',
            'url' => '#',
            'priority' => 77,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);


        MainMenu::create([
            'title_ru' => 'Персонажи',
            'title_en' => 'Characters',
            'url' => '#',
            'priority' => 73,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        MainMenu::create([
            'title_ru' => 'Соревнования',
            'title_en' => 'Competitions',
            'url' => '#',
            'priority' => 71,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        $menu = MainMenu::create([
            'title_ru' => 'Wiki',
            'title_en' => 'Wiki',
            'url' => '#',
            'priority' => 69,
            'is_active' => 1,
            'is_dropdown' => 0,
//            'parent_id' => ''
        ]);


        $menu = MainMenu::create([
            'title_ru' => 'Медиа',
            'title_en' => 'Media',
//            'url' => '#',
            'priority' => 67,
            'is_active' => 1,
            'is_dropdown' => 1
//            'parent_id' => ''
        ]);


        MainMenu::create([
            'title_ru' => 'Рынок',
            'title_en' => 'Market',
            'url' => '#',
            'priority' => 65,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        MainMenu::create([
            'title_ru' => 'Активные игроки',
            'title_en' => 'Active player',
            'url' => '#',
            'priority' => 63,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        MainMenu::create([
            'title_ru' => 'Активные игроки',
            'title_en' => 'Active player',
            'url' => '#',
            'priority' => 61,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);


        MainMenu::create([
            'title_ru' => 'Персонажи',
            'title_en' => 'Characters',
            'url' => '#',
            'priority' => 59,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        MainMenu::create([
            'title_ru' => 'Соревнования',
            'title_en' => 'Competitions',
            'url' => '#',
            'priority' => 57,
            'is_active' => 1,
            'is_dropdown' => 0,
            'parent_id' => $menu->id
        ]);

        $menu = MainMenu::create([
            'title_ru' => 'Форум',
            'title_en' => 'Forum',
            'url' => '#',
            'priority' => 69,
            'is_active' => 1,
            'is_dropdown' => 0,
//            'parent_id' => ''
        ]);

    }
}

