<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function ($user) {
            $incomes = factory(App\Income::class, rand(100,250))->make();
            $user->incomes()->saveMany($incomes);

            $expences = factory(App\Expence::class, rand(100,250))->make();
            $user->expences()->saveMany($expences);



            foreach($expences as $expence){
                // seed the prices
                $prices = factory(App\ExpencePrice::class, rand(1, 20))->make();
                $expence->prices()->saveMany($prices);

                // seed the transactions
                $transactions = factory(App\ExpenceTransaction::class, rand(10, 50))->make();
                $expence->transactions()->saveMany($transactions);
            }


            foreach($incomes as $income){
                // seed the prices
                $prices = factory(App\IncomePrice::class, rand(1, 20))->make();
                $income->prices()->saveMany($prices);

                // seed the transactions
                $transactions = factory(App\IncomeTransaction::class, rand(10, 50))->make();
                $income->transactions()->saveMany($transactions);
            }

            // // seed incomes
            // factory(App\Income::class, rand(100,250))->create()->each(function ($income) {
                
            // });


            // // seed expences
            // factory(App\Expence::class, rand(100,250))->create()->each(function ($expence) {
                
            // });

            // seed balance
            $balance = factory(App\Balance::class)->make();
            $user->balance()->save($balance);
        });
    }
}
