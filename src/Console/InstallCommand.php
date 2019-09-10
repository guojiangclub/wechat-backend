<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Console;

use Illuminate\Console\Command;
use iBrand\Wechat\Backend\Seeds\WechatBackendTablesSeeder;

class InstallCommand extends Command
{

    protected $signature = 'ibrand-wechat-backend:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ibrand wechat platform install';

    public function handle()

    {
        $this->call('db:seed', ['--class' => WechatBackendTablesSeeder::class]);

        $this->call('migrate');

        $this->info('ibrand wechat backend install successfully.');

    }


}
