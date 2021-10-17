<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $this->addProducts($order);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::query()->inRandomOrder()->first();
        $status = OrderStatus::query()->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'status_id' => $status->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'phone' => $user->phone,
            'country' => substr($this->faker->country, 0, 50),
            'city' => $this->faker->city,
            'address' => $this->faker->streetAddress,
            'total' => $this->faker->randomFloat(2, 0, 1000)
        ];
    }

    public function addProducts(Order $order)
    {
        $number = rand(1, 4);
        $ids = [];
        $sum = 0;
        for ($i = 0; $i < $number; $i++) {
            $product = Product::query()->whereNotIn('id', $ids)->inRandomOrder()->first();
            $ids[] = $product->id;
            $quantity = rand(1, 3);

            $order->products()->newPivot([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'single_price' => $product->price
            ])->save();
            $sum += ($product->price * $quantity);
        }

        $order->update(['total' => $sum]);
    }
}
