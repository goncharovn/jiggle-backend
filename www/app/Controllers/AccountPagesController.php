<?php

namespace jiggle\app\Controllers;

use jiggle\app\AccessManager;
use jiggle\app\Core\Controller;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\AccountMenu;
use jiggle\app\Views\AccountView;
use jiggle\app\Views\Layouts\DefaultLayout;

class AccountPagesController extends Controller
{
    private UserModel $user;
    private string $accountMenu;

    public function __construct()
    {
        parent::__construct();

        if (!AccessManager::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        $this->user = UserModel::getUserById($_SESSION['user_id']);
        $this->accountMenu = AccountMenu::make($this->user->getRole() === 'admin');
    }

    public function showOverviewPage(): void
    {
        $this->renderAccountPage(
            'overview',
            'My Account - Overview'
        );
    }

    public function showOrderHistoryPage(): void
    {
        $this->renderAccountPage(
            'order_history',
            'My Account - Order History'
        );
    }

    public function showDeliveryAddressPage(): void
    {
        $this->renderAccountPage(
            'delivery_addresses',
            'My Account - Delivery Addresses'
        );
    }

    public function showMyDetailsPage(): void
    {
        $this->renderAccountPage(
            'my_details',
            'My Account - My Details'
        );
    }

    private function renderAccountPage($templateName, $title): void
    {
        DefaultLayout::render(
            $title,
            AccountView::make(
                $templateName,
                $this->user,
                $this->accountMenu
            )
        );
    }
}