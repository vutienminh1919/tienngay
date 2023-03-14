<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Repository\UserRepositoryInterface::class, \App\Repository\UserRepository::class);
        $this->app->singleton(\App\Repository\RoleRepositoryInterface::class, \App\Repository\RoleRepository::class);
        $this->app->singleton(\App\Repository\MenuRepositoryInterface::class, \App\Repository\MenuRepository::class);
        $this->app->singleton(\App\Repository\InvestorRepositoryInterface::class, \App\Repository\InvestorRepository::class);
        $this->app->singleton(\App\Repository\PayRepositoryInterface::class, \App\Repository\PayRepository::class);
        $this->app->singleton(\App\Repository\ContractRepositoryInterface::class, \App\Repository\ContractRepository::class);
        $this->app->singleton(\App\Repository\InterestRepositoryInterface::class, \App\Repository\InterestRepository::class);
        $this->app->singleton(\App\Repository\TransactionRepositoryInterface::class, \App\Repository\TransactionRepository::class);
        $this->app->singleton(\App\Repository\DeviceRepositoryInterface::class, \App\Repository\DeviceRepository::class);
        $this->app->singleton(\App\Repository\NotificationRepositoryInterface::class, \App\Repository\NotificationRepository::class);
        $this->app->singleton(\App\Repository\LogPayRepositoryInterface::class, \App\Repository\LogPayRepository::class);
        $this->app->singleton(\App\Repository\LogVimoRepositoryInterface::class, \App\Repository\LogVimoRepository::class);
        $this->app->singleton(\App\Repository\LogInterestRepositoryInterface::class, \App\Repository\LogInterestRepository::class);
        $this->app->singleton(\App\Repository\LogInvestorRepositoryInterface::class, \App\Repository\LogInvestorRepository::class);
        $this->app->singleton(\App\Repository\ActionRepositoryInterface::class, \App\Repository\ActionRepository::class);
        $this->app->singleton(\App\Repository\ContractInterestRepositoryInterface::class, \App\Repository\ContractInterestRepository::class);
        $this->app->singleton(\App\Repository\InvestmentRepositoryInterface::class, \App\Repository\InvestmentRepository::class);


        $this->app->singleton(\App\Repository\CallRepositoryInterface::class, \App\Repository\CallRepository::class);
        $this->app->singleton(\App\Repository\LogCallRepositoryInterface::class, \App\Repository\LogCallRepository::class);
        $this->app->singleton(\App\Repository\LeadInvestorRepositoryInterface::class, \App\Repository\LeadInvestorRepository::class);
        $this->app->singleton(\App\Repository\ConfigCallRepositoryInterface::class, \App\Repository\ConfigCallRepository::class);
        $this->app->singleton(\App\Repository\LogConfigCallRepositoryInterface::class, \App\Repository\LogConfigCallRepository::class);
        $this->app->singleton(\App\Repository\LogChangeLeadRepositoryInterface::class, \App\Repository\LogChangeLeadRepository::class);
        $this->app->singleton(\App\Repository\LogNlRepositoryInterface::class, \App\Repository\LogNlRepository::class);
        $this->app->singleton(\App\Repository\DraftNlRepositoryInterface::class, \App\Repository\DraftNlRepository::class);
        $this->app->singleton(\App\Repository\LeadBackLogRepositoryInterface::class, \App\Repository\LeadBackLogRepository::class);
        $this->app->singleton(\App\Repository\RateInterfaceRepository::class, \App\Repository\RateRepository::class);
        $this->app->singleton(\App\Repository\CommissionRepositoryInterface::class, \App\Repository\CommissionRepository::class);
        $this->app->singleton(\App\Repository\KpiRepositoryInterface::class, \App\Repository\KpiRepository::class);
        $this->app->singleton(\App\Repository\LogKpiRepositoryInterface::class, \App\Repository\LogKpiRepository::class);
        $this->app->singleton(\App\Repository\LotteryRepositoryInterface::class, \App\Repository\LotteryRepository::class);


        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
