<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::$app->user->identity->avatarSmall ?>" class="img-circle" alt="<?= Yii::$app->user->identity->alt ?>"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->alt ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Панель Администратора', 'options' => ['class' => 'header']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Пользователи',
                        'icon' => 'user',
                        'url' => '/admin',
                        'items' => [
                            ['label' => 'Все пользователи', 'icon' => 'user-o', 'url' => '/admin/users'],
                            ['label' => 'Создать пользователя', 'icon' => 'user-plus', 'url' => '/admin/users/create'],
	                    ]
                    ],
                    [
                        'label' => 'Услуги',
                        'icon' => 'user',
                        'url' => '/admin',
                        'items' => [
                            ['label' => 'Услуги', 'icon' => 'address-card', 'url' => '/services/service',],
                            ['label' => 'Добавить Услугу', 'icon' => 'plus', 'url' => '/services/service/create',],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
