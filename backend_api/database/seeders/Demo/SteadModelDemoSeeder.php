<?php

namespace Database\Seeders\Demo;

use App\Modules\AdvancedOptions\Actions\CreateAdvancedOptionsAction;
use App\Modules\AdvancedOptions\Actions\CreateAdvancedOptionsValueAction;
use App\Modules\Owner\Actions\AddSteadToOwnerAction;
use App\Modules\Owner\Actions\CompareOwnerAndUserAction;
use App\Modules\Owner\Actions\CreateOwnerAction;
use App\Modules\Stead\Models\SteadModel;
use App\Modules\User\Models\UserModel;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SteadModelDemoSeeder extends Seeder
{

    private $options = [];
    private $lines = ['1', '2', '3', '4'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo get_class($this) . "\n";
        $this->createSteadAdvancedOptions();
        $steads = SteadModel::factory()->count(50)->create();
        $owner = null;
        foreach ($steads as $stead) {
            if ($owner && rand(0, 10) > 8) {
                // Данный участок предыдущему собственнику
            } else {
                $faker = (new Factory())->create('ru_RU');
                $name = explode(' ', $faker->name);
                $data = [
                    'surname' => $name[0],
                    'name' => $name[1],
                    'middle_name' => $name[2],
                    'general_phone' => $faker->phoneNumber,
                    'email' => $faker->safeEmail
                ];
                $owner = (new CreateOwnerAction($data))->run();
            }
            (new AddSteadToOwnerAction($stead, $owner))->run();
        }
        $steads = SteadModel::factory()->count(3)->create();
        foreach ($steads as $stead) {
            (new AddSteadToOwnerAction($stead, $owner))->run();
        }
        $user = UserModel::where('email', 'owner@examples.com')->first();

        (new CompareOwnerAndUserAction($owner, $user))->run();
        foreach (SteadModel::all() as $stead) {
            foreach ($this->options as $option) {
                $value = '';
                if ($option->type_value == 'select' && $option->options['selectOptions']) {
                    $value = $option->options['selectOptions'][array_rand($option->options['selectOptions'])];
                } else {
                    if ($option->type_value == 'boolean') {
                        $value = rand(0, 10) > 3 ? 1 : 0;
                    }
                }
                (new CreateAdvancedOptionsValueAction($option, $stead->id))
                    ->value($value)
                    ->run();
            }
        }
    }


    private function createSteadAdvancedOptions()
    {
        $this->options[] = (new CreateAdvancedOptionsAction())
            ->fill([
                'name' => 'Линия',
                'type_value' => 'select',
                'options' => [
                    'selectOptions' => $this->lines,
                    'unitName' => 'линия'
                ],
                'type' => 'options'
            ])
            ->object('stead')
            ->run();
        $this->options[] = (new CreateAdvancedOptionsAction())
            ->fill([
                'name' => 'Электрифицирован',
                'type_value' => 'boolean',
                'options' => [
                    'defaultValue' => false
                ],
                'type' => 'options'
            ])
            ->object('stead')
            ->run();
    }


}


