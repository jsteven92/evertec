<?php

namespace App\Console;

use App\Repositories\Eloquent\OrderPayMentRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Services\OrderService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            $orderPaymentRepository = new OrderPayMentRepository();
            $orderRepository = new OrderRepository();
            $result = $orderPaymentRepository->getRequestIdOrderPending();

            foreach ($result as $orderPayment) {
                $orderService = new OrderService($orderRepository,$orderPaymentRepository);
                $orderService->verifyStatusOrder($orderPayment->request_id);
            }
            
        })->everyMinute();
    
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
